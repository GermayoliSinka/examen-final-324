const canvas = document.getElementById("webglCanvas");
const gl = canvas.getContext("webgl");

const vertexShaderSource = `
    attribute vec2 posicion;
    attribute vec3 color;
    varying vec3 vColor;
    void main() {
        gl_Position = vec4(posicion, 0.0, 1.0);
        vColor = color;
    }
`;

const fragmentShaderSource = `
    precision mediump float;
    varying vec3 vColor;
    void main() {
        gl_FragColor = vec4(vColor, 1.0);
    }
`;

const compileShader = (type, source) => {
    const shader = gl.createShader(type);
    gl.shaderSource(shader, source);
    gl.compileShader(shader);
    return shader;
};

const program = gl.createProgram();
gl.attachShader(program, compileShader(gl.VERTEX_SHADER, vertexShaderSource));
gl.attachShader(program, compileShader(gl.FRAGMENT_SHADER, fragmentShaderSource));
gl.linkProgram(program);
gl.useProgram(program);


const vertices = new Float32Array([
    0.0,  0.5,  1.0, 0.0, 0.0,        //(255, 0,0)
   -0.5, -0.5,  0.0, 1.0, 0.0,        //(0,255,0)
    0.5, -0.5,  0.0, 0.0, 1.0         //(0,0,255)
]);

const buffer = gl.createBuffer();
gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
gl.bufferData(gl.ARRAY_BUFFER, vertices, gl.STATIC_DRAW);


const setupAttribute = (name, size, stride, offset) => {
    const location = gl.getAttribLocation(program, name);
    gl.vertexAttribPointer(location, size, gl.FLOAT, false, stride, offset);
    gl.enableVertexAttribArray(location);
};
setupAttribute("posicion", 2, 20, 0); 
setupAttribute("color", 3, 20, 8);    

// Dibujar
gl.clear(gl.COLOR_BUFFER_BIT);
gl.drawArrays(gl.TRIANGLES, 0, 3);
