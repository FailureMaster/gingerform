<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Drawing Form</title>
    <style>
        #canvas {
            border: 1px solid #000;
        }
    </style>
</head>
<body>
    <form id="drawingForm" action="<?= site_url('drawingform/submit') ?>" method="post">
        <input type="text" name="name" placeholder="Your Name" required><br>
        <input type="email" name="email" placeholder="Your Email" required><br>
        <canvas id="canvas" width="400" height="400"></canvas><br>
        <button type="submit">Submit</button>
    </form>

    <script>
    const canvas = document.getElementById('canvas');
    const ctx = canvas.getContext('2d');
    let drawing = false;

    // Start a new path each time the mouse is pressed
    canvas.addEventListener('mousedown', (event) => {
        drawing = true;
        ctx.beginPath();
        ctx.moveTo(event.clientX - canvas.offsetLeft, event.clientY - canvas.offsetTop);
    });

    // Stop drawing when the mouse is released
    canvas.addEventListener('mouseup', () => {
        drawing = false;
    });

    // Stop drawing when the mouse leaves the canvas
    canvas.addEventListener('mouseout', () => {
        drawing = false;
    });

    // Draw on the canvas
    canvas.addEventListener('mousemove', draw);

    function draw(event) {
        if (!drawing) return;
        ctx.lineWidth = 5;
        ctx.lineCap = 'round';
        ctx.strokeStyle = '#000';

        ctx.lineTo(event.clientX - canvas.offsetLeft, event.clientY - canvas.offsetTop);
        ctx.stroke();
    }

    document.getElementById('drawingForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const dataURL = canvas.toDataURL();
        const formData = new FormData(this);
        formData.append('drawing', dataURL);

        fetch(this.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert('Form submitted successfully!');
        })
        .catch(error => {
            console.error('Error:', error);
        });
    });
</script>

</body>
</html>
