<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unicode Character Sanitizer</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f7f7f7;
            min-height: 100vh;
        }
    </style>
</head>
<body class="p-4 sm:p-8">

    <div id="app" class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">
        <header class="mb-6">
            <h1 class="text-3xl font-extrabold text-indigo-700 mb-2">Unicode Sanitizer</h1>
            <p class="text-gray-600">Converts common "smart" Unicode characters (like curled quotes and long dashes) to their basic plain-text equivalents.</p>
        </header>

        <section class="mb-8">
            <label for="input-text" class="block text-lg font-semibold text-gray-800 mb-2">Paste Content Here (Input)</label>
            <textarea id="input-text" rows="10" class="w-full p-3 border-2 border-indigo-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 text-gray-800 transition duration-150 ease-in-out" placeholder="Paste your document content here..."></textarea>
        </section>

        <div class="flex flex-col sm:flex-row gap-4 mb-8">
            <button id="sanitize-button" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-[1.01]">
                Sanitize Text
            </button>
            <button id="copy-button" class="flex-1 bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-[1.01]">
                Copy Sanitized Text
            </button>
        </div>

        <section>
            <label for="output-text" class="block text-lg font-semibold text-gray-800 mb-2">Sanitized Content (Output)</label>
            <textarea id="output-text" rows="10" readonly class="w-full p-3 border-2 border-gray-300 bg-gray-50 rounded-lg text-gray-800 focus:outline-none resize-none"></textarea>
        </section>

        <div id="message-box" class="mt-4 p-3 bg-indigo-100 border border-indigo-300 text-indigo-800 rounded-lg hidden" role="alert"></div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const inputTextArea = document.getElementById('input-text');
            const outputTextArea = document.getElementById('output-text');
            const sanitizeButton = document.getElementById('sanitize-button');
            const copyButton = document.getElementById('copy-button');
            const messageBox = document.getElementById('message-box');

            // List of common Unicode characters and their plain-text replacements
            const characterMap = {
                // Smart Quotes
                '“': '"',
                '”': '"',
                '‘': "'",
                '’': "'",
                // Special Dashes
                '—': '---', // Em-dash replacement for LaTeX
                '–': '--',  // En-dash replacement for LaTeX
                // Ellipsis
                '…': '...',
                // Non-standard Spaces (including non-breaking space)
                '\u00a0': ' ', // Non-breaking space
                '\u2007': ' ', // Figure space
                '\u202f': ' ', // Narrow non-breaking space
                // Multiplication sign
                '×': 'x',
                // Bullets (if accidentally copied)
                '•': '-',
            };

            function showMessage(text, type = 'info') {
                messageBox.textContent = text;
                messageBox.className = `mt-4 p-3 rounded-lg block ${
                    type === 'success' ? 'bg-green-100 border-green-300 text-green-800' :
                    'bg-indigo-100 border-indigo-300 text-indigo-800'
                }`;
                setTimeout(() => {
                    messageBox.classList.add('hidden');
                }, 3000);
            }

            function sanitizeText(text) {
                let sanitized = text;
                
                // 1. Replace common mapping characters
                for (const [unicode, replacement] of Object.entries(characterMap)) {
                    // Use global regex to replace all instances
                    const regex = new RegExp(unicode, 'g');
                    sanitized = sanitized.replace(regex, replacement);
                }

                // 2. Normalize common weird spaces (like ZWNJ, etc.)
                // This targets anything that looks like a space but isn't a standard ASCII space
                sanitized = sanitized.replace(/[\u2000-\u200A\u202F\u205F\u3000]/g, ' ');

                return sanitized;
            }

            sanitizeButton.addEventListener('click', () => {
                const inputText = inputTextArea.value;
                if (!inputText.trim()) {
                    showMessage("Please paste content into the input box first.", 'info');
                    return;
                }
                const sanitizedText = sanitizeText(inputText);
                outputTextArea.value = sanitizedText;
                showMessage("Text successfully sanitized!", 'success');
            });

            copyButton.addEventListener('click', () => {
                const outputText = outputTextArea.value;
                if (!outputText.trim()) {
                    showMessage("Please sanitize the text before attempting to copy.", 'info');
                    return;
                }
                
                // Use execCommand('copy') as navigator.clipboard might fail in some environments
                outputTextArea.select();
                outputTextArea.setSelectionRange(0, 99999); // For mobile devices
                try {
                    document.execCommand('copy');
                    showMessage("Sanitized text copied to clipboard!", 'success');
                } catch (err) {
                    console.error('Could not copy text: ', err);
                    showMessage("Failed to copy. Please manually select and copy the text in the output box.", 'info');
                }
            });
        });
    </script>
</body>
</html>
