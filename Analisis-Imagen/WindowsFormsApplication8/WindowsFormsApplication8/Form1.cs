using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace WindowsFormsApplication8
{
    public partial class Form1 : Form
    {
        private Bitmap frame1;
        private Bitmap frame2;


        public Form1()
        {
            InitializeComponent();
        }

        private void button2_Click(object sender, EventArgs e)
        {
            if (frame1 == null || frame2 == null)
            {
                MessageBox.Show("Cargue ambos fotogramas antes de detectar movimiento.");
                return;
            }

            if (frame1.Width != frame2.Width || frame1.Height != frame2.Height)
            {
                MessageBox.Show("Los fotogramas deben tener las mismas dimensiones.");
                return;
            }

            Bitmap result = new Bitmap(frame1.Width, frame1.Height);
            int changesDetected = 0; // Contador de cambios detectados


            // Comparar las imágenes y generar la imagen de cambios
            for (int x = 0; x < frame1.Width; x++)
            {
                for (int y = 0; y < frame1.Height; y++)
                {
                    Color color1 = frame1.GetPixel(x, y);
                    Color color2 = frame2.GetPixel(x, y);

                    int diffR = Math.Abs(color1.R - color2.R);
                    int diffG = Math.Abs(color1.G - color2.G);
                    int diffB = Math.Abs(color1.B - color2.B);

                    int threshold = 50; // Ajusta según la sensibilidad deseada
                    if (diffR > threshold || diffG > threshold || diffB > threshold)
                    {
                        result.SetPixel(x, y, Color.Red);
                    }
                    else
                    {
                        result.SetPixel(x, y, Color.Black);
                    }
                }
            }

            pictureBox3.Image = result;

            if (changesDetected > 0)
            {
                textBox1.Text = changesDetected.ToString();
                textBox1.AppendText(Text.ToString()); // Mostrar las posiciones de los cambios
            }
            else
            {
                textBox1.Text = "No se detectaron cambios significativos.";
            }
        }

        private void button3_Click(object sender, EventArgs e)
        {
            openFileDialog1.Filter = "Imágenes|*.jpg;*.png";
            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                frame2 = new Bitmap(openFileDialog1.FileName);
                pictureBox2.Image = frame2;
            }
        }

        private void button1_Click(object sender, EventArgs e)
        {
            openFileDialog1.Filter = "Imágenes|*.jpg;*.png";
            if (openFileDialog1.ShowDialog() == DialogResult.OK)
            {
                frame1 = new Bitmap(openFileDialog1.FileName);
                pictureBox1.Image = frame1;
            }
        }

        private void pictureBox1_Click(object sender, EventArgs e)
        {

        }
    }
}
