// Vertex Shader
const vertexShaderSource = `
    attribute vec2 posicion;
    varying vec2 vPos;
    void main() {
        gl_Position = vec4(posicion, 0.0, 1.0);
        vPos = posicion; // Pasar la posición al fragment shader
    }
`;

// Fragment Shader
const fragmentShaderSource = `
    precision mediump float;
    varying vec2 vPos;
    void main() {
        // Crear un degradado basado en la posición Y del canvas
        float intensity = (vPos.y + 1.0) / 2.0; // Normalizar a [0, 1]
        vec3 color = mix(vec3(0.2, 0.2, 0.6), vec3(0.8, 0.8, 1.0), intensity); // De azul oscuro a azul claro
        gl_FragColor = vec4(color, 1.0);
    }
`;

const canvas = document.getElementById("webglCanvas");
const gl = canvas.getContext("webgl");

const compileShader = (type, source) => {
    const shader = gl.createShader(type);
    gl.shaderSource(shader, source);
    gl.compileShader(shader);
    if (!gl.getShaderParameter(shader, gl.COMPILE_STATUS)) {
        console.error("Shader compilation error:", gl.getShaderInfoLog(shader));
        gl.deleteShader(shader);
        return null;
    }
    return shader;
};

const program = gl.createProgram();
const vertexShader = compileShader(gl.VERTEX_SHADER, vertexShaderSource);
const fragmentShader = compileShader(gl.FRAGMENT_SHADER, fragmentShaderSource);
gl.attachShader(program, vertexShader);
gl.attachShader(program, fragmentShader);
gl.linkProgram(program);
if (!gl.getProgramParameter(program, gl.LINK_STATUS)) {
    console.error("Program linking error:", gl.getProgramInfoLog(program));
}
gl.useProgram(program);

const vertices = new Float32Array([
    0.0,  0.5,  // Vértice superior
   -0.5, -0.5,  // Vértice inferior izquierdo
    0.5, -0.5   // Vértice inferior derecho
]);

const buffer = gl.createBuffer();
gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW);

const positionLocation = gl.getAttribLocation(program, "posicion");
gl.vertexAttribPointer(positionLocation, 2, gl.FLOAT, false, 0, 0);
gl.enableVertexAttribArray(positionLocation);

gl.clear(gl.COLOR_BUFFER_BIT);

gl.drawArrays(gl.TRIANGLES, 0, 3);
