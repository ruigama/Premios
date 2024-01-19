function verificaQuantidade()
{
    var quantidade = document.getElementById("quantidade").value;
    var total = document.getElementById("total").value;
    quantidade = parseInt(quantidade);
    total = parseInt(total);

    if(quantidade == 0 || quantidade == null || quantidade == "" || quantidade == undefined)
    {
        alert("É necessário definir uma quantidade para distribuir!");
        document.getElementById("btn_distribuir").disabled = true; 
        document.getElementById("btnCarregar").disabled = true;
    }
    if(quantidade > total)
    {
        alert("Quantidade escolhida está acima do total cadastrado!")
        document.getElementById("btn_distribuir").disabled = true;
    }
    else
    {
        document.getElementById("btn_distribuir").disabled = false;
        document.getElementById("btnCarregar").disabled = false;
    }
}

function quantidadeProduto()
{
    var quantidade_premio = document.getElementById("quantidade_premio").value;

    if(quantidade_premio == 0)
    {
        alert("É necessário definir uma quantidade para distribuir!");
        document.getElementById("btn_atulizar_qtd").disabled = true;
    }
    else
    {
        document.getElementById("btn_atulizar_qtd").disabled = false;
    }
}

function sorteio()
{
    document.getElementById('tabelaSortear').style.display='block';
    
    fetch('http://premios.wocc/sorteio')
        .then(response => response.json())
        .then(data => 
            {
                const tbody = document.querySelector('#tabela tbody');
                const resultados = data;

                data.forEach(item =>{
                    const tr = document.createElement('tr');
                    tbody.appendChild(tr);

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.value = `${item.matricula} - ${item.nome}`;

                    const tdCheckbox = document.createElement('td');
                    tdCheckbox.appendChild(checkbox);
                    tr.appendChild(tdCheckbox);

                    const td1 = document.createElement('td');
                    td1.textContent = item.matricula;
                    tr.appendChild(td1);

                    const td2 = document.createElement('td');
                    td2.textContent = item.nome;
                    tr.appendChild(td2);

                });

                console.log(resultados);
            })
        .catch(error => console.error(error));
}

function sortear() 
{
    const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
    const itens = Array.from(checkboxes).map(checkbox => checkbox.value);
    var velocidade = 50;
    var tempo = 2000;
    var sorteando = false;
    if (sorteando) return;

    sorteando = true;
    var resultado = document.getElementById("result");
    var sorteado = Math.floor(Math.random() * itens.length);
    var contador = 0;

    var sorteio = setInterval(function() 
    {
        contador++;
        resultado.innerHTML = itens[Math.floor(Math.random() * itens.length)];

        if (contador > tempo / velocidade) 
        {
            clearInterval(sorteio);
            resultado.innerHTML = itens[sorteado];
            document.getElementById("popup-item").innerHTML = itens[sorteado];
            document.getElementById("popup").classList.add
            ("active");
            document.getElementById("popup-text").innerHTML = "O item sorteado foi: ";
            sorteando = false;
        }
    }, velocidade);
}

function fecharPopup() 
{
    document.getElementById('divSorteado').style.display='block';
    let matricula = document.getElementById("popup-item").textContent;
    let id_premio = document.getElementById("id").value;

    document.getElementById('matricula_sorteado').value = matricula;
    document.getElementById('id_sorteado').value = id_premio;


    document.getElementById("popup").classList.remove("active");
    document.getElementById("popup-item").innerHTML = "";
    document.getElementById("popup-text").innerHTML = "";
}
