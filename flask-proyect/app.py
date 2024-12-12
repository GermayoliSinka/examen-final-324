from flask import Flask, render_template, request, redirect, url_for
import mysql.connector

app = Flask(__name__)

#conectar
def get_db_connection():
    connection = mysql.connector.connect(
        host='localhost',
        user='root',
        password='',
        database='sistema_tarea'
    )
    return connection


@app.route('/')
def home():
    connection = get_db_connection()
    cursor = connection.cursor(dictionary=True)
    
    # Consultar tareas
    cursor.execute(""" 
        SELECT t.id, t.descripcion, u.nombre AS usuario, e.nombre AS estado, p.nombre AS prioridad, t.fecha_limite
        FROM tarea t
        JOIN usuarios u ON t.usuario_id = u.id
        JOIN estadostarea e ON t.estado_id = e.id
        JOIN prioridad p ON t.prioridad_id = p.id
    """)
    tareas = cursor.fetchall()
    
    cursor.execute("SELECT * FROM usuarios")
    usuarios = cursor.fetchall()
    
    cursor.close()
    connection.close()
    
    return render_template('index.html', tareas=tareas, usuarios=usuarios)

@app.route('/editar_tarea/<int:tarea_id>', methods=['GET', 'POST'])
@app.route('/nueva_tarea', methods=['GET', 'POST'])
def editar_tarea(tarea_id=None):
    connection = get_db_connection()
    cursor = connection.cursor(dictionary=True)
    
    cursor.execute("SELECT * FROM usuarios")
    usuarios = cursor.fetchall()
    
    cursor.execute("SELECT * FROM estadostarea")
    estados = cursor.fetchall()
    
    cursor.execute("SELECT * FROM prioridad")
    prioridades = cursor.fetchall()

    if request.method == 'POST':
        descripcion = request.form['descripcion']
        usuario_id = request.form['usuario_id']
        estado_id = request.form['estado_id']
        prioridad_id = request.form['prioridad_id']
        fecha_limite = request.form['fecha_limite']
        
        if tarea_id:
            cursor.execute(""" 
                UPDATE tarea SET descripcion = %s, usuario_id = %s, estado_id = %s, prioridad_id = %s, fecha_limite = %s 
                WHERE id = %s
            """, (descripcion, usuario_id, estado_id, prioridad_id, fecha_limite, tarea_id))
        else:
            # Crear nueva tarea
            cursor.execute(""" 
                INSERT INTO tarea (descripcion, usuario_id, estado_id, prioridad_id, fecha_limite) 
                VALUES (%s, %s, %s, %s, %s)
            """, (descripcion, usuario_id, estado_id, prioridad_id, fecha_limite))
        
        connection.commit()
        cursor.close()
        connection.close()
        return redirect(url_for('home'))
    
    if tarea_id:
        cursor.execute("SELECT * FROM tarea WHERE id = %s", (tarea_id,))
        tarea = cursor.fetchone()
        return render_template('editar_tarea.html', tarea=tarea, usuarios=usuarios, estados=estados, prioridades=prioridades)
    
    cursor.close()
    connection.close()
    return render_template('editar_tarea.html', usuarios=usuarios, estados=estados, prioridades=prioridades)


@app.route('/eliminar_usuario/<int:usuario_id>')
def eliminar_usuario(usuario_id):
    connection = get_db_connection()
    cursor = connection.cursor()

    cursor.execute("DELETE FROM tarea WHERE usuario_id = %s", (usuario_id,))

    cursor.execute("DELETE FROM usuarios WHERE id = %s", (usuario_id,))

    connection.commit()
    cursor.close()
    connection.close()

    return redirect(url_for('home'))


@app.route('/editar_usuario/<int:usuario_id>', methods=['GET', 'POST'])
@app.route('/nuevo_usuario', methods=['GET', 'POST'])
def editar_usuario(usuario_id=None):
    if request.method == 'POST':
        nombre = request.form['nombre']
        correo = request.form['correo']
        
        connection = get_db_connection()
        cursor = connection.cursor()
        
        if usuario_id:
            cursor.execute(""" 
                UPDATE usuarios SET nombre = %s, correo = %s WHERE id = %s
            """, (nombre, correo, usuario_id))
        else:
            cursor.execute(""" 
                INSERT INTO usuarios (nombre, correo) VALUES (%s, %s)
            """, (nombre, correo))
        
        connection.commit()
        cursor.close()
        connection.close()
        return redirect(url_for('home'))
    
    if usuario_id:
        connection = get_db_connection()
        cursor = connection.cursor(dictionary=True)
        cursor.execute("SELECT * FROM usuarios WHERE id = %s", (usuario_id,))
        usuario = cursor.fetchone()
        return render_template('editar_usuario.html', usuario=usuario)
    
    return render_template('editar_usuario.html')

if __name__ == '__main__':
    app.run(debug=True)
