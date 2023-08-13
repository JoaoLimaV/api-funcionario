# API Funcinários - Framework Lumen

Essa API foi desenvolvida para utilizar na disciplina de Laboratório de Desenvolvimento Web, proporcionando uma plataforma interativa e bem estruturada para a aplicação prática dos conceitos aprendidos. Com recursos abrangentes que vão desde fundamentos até técnicas avançadas, a API prepara os alunos para os desafios profissionais ao mesmo tempo em que eleva a qualidade do ensino.


##  Documentação API Funcionários

##  EndPoints

<strong> Get All Employee </small> <br>
http://129.148.27.50/api/funcionario
Method: GET <br>

Return: 
<pre>
    [
        {
          "id": 1,
          "nome": "Adriana Souza",
          "telefone": "(21) 9876-5432",
          "cpf": "98765432100",
          "rg": "9876543",
          "endereco": "Avenida B, 456",
          "data_nascimento": "1988-09-22",
          "cargo": "Gerente de Marketing",
          "data_admissao": "2022-11-02",
          "data_demissao": null,
          "email": "maria.souza@email.com",
          "sexo": "Feminino",
          "status": 1
        }, 
        {
          "id": 1,
          "nome": "Adriana Souza",
          ...
        }
    ] 
</pre>
##
<strong> Find Employee </small> <br>
http://129.148.27.50/api/funcionario/{id}
Method: GET <br>

Return: 
<pre>
    {
        "id": 1,
        "nome": "Adriana Souza",
        "telefone": "(21) 9876-5432",
        "cpf": "98765432100",
        "rg": "9876543",
        "endereco": "Avenida B, 456",
        "data_nascimento": "1988-09-22",
        "cargo": "Gerente de Marketing",
        "data_admissao": "2022-11-02",
        "data_demissao": null,
        "email": "maria.souza@email.com",
        "sexo": "Feminino",
        "status": 1
    }
</pre>
##
<strong> Save Employee </small> <br>
http://129.148.27.50/api/funcionario/save
Method: POST <br>

Body: 
<pre>
    {
        "nome": "Adriana Souza",
        "telefone": "(21) 9876-5432",
        "cpf": "98765432100",
        "rg": "9876543",
        "endereco": "Avenida B, 456",
        "data_nascimento": "1988-09-22",
        "cargo": "Gerente de Marketing",
        "data_admissao": "2022-11-02",
        "data_demissao": null,
        "email": "maria.souza@email.com",
        "sexo": "Feminino",
        "status": 1
    }
</pre>

Return: 
<pre>
    {
      "status": "200",
      "message": "Funcionário criado com sucesso",
      "data": {
            "id": 22,
            "nome": "Adriana Souza",
            "telefone": "(21) 9876-5432",
            "cpf": "98765432100",
            "rg": null,
            "endereco": null,
            "data_nascimento": null,
            "cargo": null,
            "data_admissao": "2022-11-02",
            "data_demissao": null,
            "email": "maria.souza@email.com",
            "sexo": "Feminino",
            "status": 1
      }
}
</pre>
##
<strong> Update Employee </small> <br>
http://129.148.27.50/api/funcionario/updade/
Method: UPDATE <br>

Body: 
<pre>
    {
        "endereco": "Avenida B, 456",
        "cargo": "Gerente de Marketing"
        .. data to update
    }
</pre>

Return: 
<pre>
    {

    }
</pre>
##
<strong> Delete Employee </small> <br>
http://129.148.27.50/api/funcionario/delete/{id}
Method: DELETE <br>

Return: 
<pre>
    {
    
    }
</pre>
