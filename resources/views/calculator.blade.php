<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Calculator</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .calculator {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            padding: 30px;
            width: 100%;
            max-width: 400px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-size: 28px;
        }

        .display {
            background: #f0f0f0;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            text-align: right;
            font-size: 32px;
            font-weight: bold;
            min-height: 70px;
            word-wrap: break-word;
            color: #333;
        }

        .buttons {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
        }

        button {
            padding: 20px;
            font-size: 20px;
            font-weight: bold;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.2s;
            background: #f0f0f0;
            color: #333;
        }

        button:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        button:active {
            transform: translateY(0);
        }

        .number {
            background: #f5f5f5;
        }

        .operation {
            background: #667eea;
            color: white;
        }

        .operation:hover {
            background: #5568d3;
        }

        .equals {
            background: #764ba2;
            color: white;
            grid-column: span 2;
        }

        .equals:hover {
            background: #63408a;
        }

        .clear {
            background: #ff6b6b;
            color: white;
        }

        .clear:hover {
            background: #ee5a52;
        }

        .error {
            color: #ff6b6b;
        }
    </style>
</head>
<body>
    <div class="calculator">
        <h1>🔢 Calculator</h1>
        <div class="display" id="display">0</div>
        
        <div class="buttons">
            <button class="number" onclick="appendNumber('7')">7</button>
            <button class="number" onclick="appendNumber('8')">8</button>
            <button class="number" onclick="appendNumber('9')">9</button>
            <button class="operation" onclick="setOperation('divide')">÷</button>
            
            <button class="number" onclick="appendNumber('4')">4</button>
            <button class="number" onclick="appendNumber('5')">5</button>
            <button class="number" onclick="appendNumber('6')">6</button>
            <button class="operation" onclick="setOperation('multiply')">×</button>
            
            <button class="number" onclick="appendNumber('1')">1</button>
            <button class="number" onclick="appendNumber('2')">2</button>
            <button class="number" onclick="appendNumber('3')">3</button>
            <button class="operation" onclick="setOperation('subtract')">-</button>
            
            <button class="clear" onclick="clearDisplay()">C</button>
            <button class="number" onclick="appendNumber('0')">0</button>
            <button class="number" onclick="appendNumber('.')">.</button>
            <button class="operation" onclick="setOperation('add')">+</button>
            
            <button class="equals" onclick="calculate()">=</button>
        </div>
    </div>

    <script>
        let currentDisplay = '0';
        let firstNumber = null;
        let operation = null;
        let newNumber = true;

        function updateDisplay() {
            document.getElementById('display').textContent = currentDisplay;
            document.getElementById('display').classList.remove('error');
        }

        function appendNumber(num) {
            if (newNumber) {
                currentDisplay = num;
                newNumber = false;
            } else {
                if (currentDisplay === '0' && num !== '.') {
                    currentDisplay = num;
                } else if (num === '.' && currentDisplay.includes('.')) {
                    return;
                } else {
                    currentDisplay += num;
                }
            }
            updateDisplay();
        }

        function setOperation(op) {
            firstNumber = parseFloat(currentDisplay);
            operation = op;
            newNumber = true;
        }

        function clearDisplay() {
            currentDisplay = '0';
            firstNumber = null;
            operation = null;
            newNumber = true;
            updateDisplay();
        }

        async function calculate() {
            if (operation === null || firstNumber === null) return;

            const secondNumber = parseFloat(currentDisplay);
            
            try {
                const response = await fetch('{{ route("calculator.calculate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        num1: firstNumber,
                        num2: secondNumber,
                        operation: operation
                    })
                });

                const data = await response.json();

                if (data.error) {
                    currentDisplay = data.error;
                    document.getElementById('display').classList.add('error');
                } else {
                    currentDisplay = data.result.toString();
                }

                firstNumber = null;
                operation = null;
                newNumber = true;
                updateDisplay();
            } catch (error) {
                currentDisplay = 'Error';
                document.getElementById('display').classList.add('error');
                updateDisplay();
            }
        }

        // Keyboard support
        document.addEventListener('keydown', function(event) {
            const key = event.key;
            
            // Numbers 0-9
            if (key >= '0' && key <= '9') {
                appendNumber(key);
            }
            // Decimal point
            else if (key === '.') {
                appendNumber('.');
            }
            // Operations
            else if (key === '+') {
                setOperation('add');
            }
            else if (key === '-') {
                setOperation('subtract');
            }
            else if (key === '*') {
                setOperation('multiply');
            }
            else if (key === '/') {
                event.preventDefault(); // Prevent browser search
                setOperation('divide');
            }
            // Enter or = for calculate
            else if (key === 'Enter' || key === '=') {
                event.preventDefault();
                calculate();
            }
            // Escape or C for clear
            else if (key === 'Escape' || key === 'c' || key === 'C') {
                clearDisplay();
            }
            // Backspace to delete last character
            else if (key === 'Backspace') {
                event.preventDefault();
                if (currentDisplay.length > 1) {
                    currentDisplay = currentDisplay.slice(0, -1);
                } else {
                    currentDisplay = '0';
                }
                updateDisplay();
            }
        });

        updateDisplay();
    </script>
</body>
</html>