# API Funcinários - Framework Lumen

Essa API foi desenvolvida para utilizar na disciplina de Laboratório de Desenvolvimento Web, proporcionando uma plataforma interativa e bem estruturada para a aplicação prática dos conceitos aprendidos. Com recursos abrangentes que vão desde fundamentos até técnicas avançadas, a API prepara os alunos para os desafios profissionais ao mesmo tempo em que eleva a qualidade do ensino.


This API was developed for use in the Web Development Laboratory course, providing an interactive and well-structured platform for the practical application of the concepts learned. With comprehensive features ranging from fundamentals to advanced techniques, the API prepares students for professional challenges while enhancing the quality of education.

##  API documentation

##  EndPoints

<strong> Get All Employee </strong> <br>
http://129.148.27.50/api/funcionario
Method: GET <br>

Sucess return: 
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

Failed return: 
<pre>
    {
        "message": "Funcionário não encontrado"
    }
</pre>
##
<strong> Find Employee </strong> <br>
http://129.148.27.50/api/funcionario/{id}
Method: GET <br>

Sucess return: 
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

Failed return: 
<pre>
    {
        "message": "Funcionário não encontrado"
    }
</pre>
##
<strong> Save Employee </strong> <br>
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

Sucess return: 
<pre>
    {
      "message": "Funcionário criado com sucesso",
      "employee": {
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
    }
</pre>
Failed return: 
<pre>
    {
      "message": "Erro ao criar funcionário"
    }
</pre>

##
<strong> Update Employee </strong> <br>
http://129.148.27.50/api/funcionario/updade/{id}
Method: PUT <br>

Body: 
<pre>
    {
        "nome": "Andreia dos Santos",
        "email": "andreia.santos@email.com"
        .. data to update
    }
</pre>

Sucess return: 
<pre>
    {
      "message": "Funcionário atualizado com sucesso",
      "employee": {
            "id": 1,
            "nome": "Andreia dos Santos",
            "telefone": "36987465452",
            "cpf": "98765432100",
            "rg": "1234567",
            "endereco": "Praça Y, 789",
            "data_nascimento": "1990-12-18",
            "cargo": "Coordenadora de Recursos Humanos",
            "data_admissao": "2019-08-20",
            "data_demissao": "2023-07-31",
            "email": "andreia.santos@email.com",
            "sexo": "Feminino",
            "status": 1
        }
    }
</pre>

Failed return: 
<pre>
    {
      "message": "Funcionário não encontrado"
    }
</pre>

##
<strong> Delete Employee </strong> <br>
http://129.148.27.50/api/funcionario/delete/{id}
Method: DELETE <br>

Sucess return: 
<pre>
    {
        "message": "Funcionário deletado com sucesso"
    }
</pre>

Failed return: 
<pre>
    {
        "message": "Funcionário não encontrado"
    }
</pre>

##

<strong> Aditional Informations </strong> <br>

For certain methods such as SAVE and UPDATE, the API provides extensive error messages for empty fields or fields with incorrect characters.

Null values (this only for the SAVE method):

<pre>
    {
      "nome": [
        "The nome field is required."
      ],
      "endereco": [
        "The endereco field is required."
      ],
      "data_nascimento": [
        "The data nascimento field is required."
      ],
      "cargo": [
        "The cargo field is required."
      ],
      "data_admissao": [
        "The data admissao field is required."
      ],
      "email": [
        "The email field is required."
      ],
      "sexo": [
        "The sexo field is required."
      ]
    }
</pre>

Max characters:

<pre>
    {
      "telefone": [
        "The telefone must not be greater than 11 characters."
      ],
      "cpf": [
        "The cpf must not be greater than 11 characters."
      ],
      "data_nascimento": [
        "The data nascimento must not be greater than 10 characters."
      ],
      "data_admissao": [
        "The data admissao must not be greater than 10 characters."
      ]
    }
</pre>

Min characters:

<pre>
    {
      "telefone": [
        "The telefone must be at least 10 characters."
      ],
      "cpf": [
        "The cpf must be at least 10 characters."
      ],
      "data_nascimento": [
        "The data nascimento must be at least 10 characters."
      ],
      "data_admissao": [
        "The data admissao must be at least 10 characters."
      ]
    }
</pre>

Unique values:

<pre>
    {
      "telefone": [
        "The telefone has already been taken."
      ],
      "cpf": [
        "The cpf has already been taken."
      ],
      "email": [
        "The email has already been taken."
      ]
    }
</pre>

Invalid email:

<pre>
    {
      "email": [
        "The email must be a valid email address."
      ]
    }
</pre>
