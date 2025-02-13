// chat.js

document.addEventListener('DOMContentLoaded', function() {
    const chatMensagens = document.getElementById('chatMensagens');
    const mensagemInput = document.getElementById('mensagem');
    const enviarMensagem = document.getElementById('enviarMensagem');

    function adicionarMensagem(mensagem) {
        const mensagemDiv = document.createElement('div');
        mensagemDiv.textContent = mensagem;
        chatMensagens.appendChild(mensagemDiv);
        chatMensagens.scrollTop = chatMensagens.scrollHeight; // Rolagem automática para o final
    }

    function enviar() {
        const mensagem = mensagemInput.value.trim();
        const nickname = dados_entrada.nick; // Supondo que você tenha o nickname salvo aqui
        if (mensagem) {
            fetch('enviar_mensagem.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json', // Usando JSON para enviar dados
                },
                body: JSON.stringify({
                    mensagem: mensagem,
                    nickname: nickname, // Enviando o nickname junto com a mensagem
                }),
            })
            .then(response => response.text())
            .then(() => {
                mensagemInput.value = '';
                carregarMensagens();
            })
            .catch(error => console.error('Erro ao enviar mensagem:', error));
        }
    }
    

    function carregarMensagens() {
        fetch('receber_mensagens.php')
            .then(response => response.json())
            .then(data => {
                chatMensagens.innerHTML = '';
                data.forEach(msg => {
                    const [nickname, ...resto] = msg.split(': '); // Separar nickname e mensagem
                    const mensagemTexto = resto.join(': '); // Juntar o resto para a mensagem
    
                    const mensagemDiv = document.createElement('div');
                    mensagemDiv.innerHTML = `<strong>${nickname}</strong>: ${mensagemTexto}`; // Exibir nickname em negrito
                    chatMensagens.appendChild(mensagemDiv);
                });
                chatMensagens.scrollTop = chatMensagens.scrollHeight; // Rolagem automática para o final
            })
            .catch(error => console.error('Erro ao carregar mensagens:', error));
    }
    

    enviarMensagem.addEventListener('click', enviar);
    mensagemInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            enviar();
        }
    });

    carregarMensagens();
    setInterval(carregarMensagens, 1000); // Atualizar mensagens a cada 5 segundos
});
