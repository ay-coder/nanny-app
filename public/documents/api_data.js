define({ "api": [
  {
    "type": "post",
    "url": "forgotpassword",
    "title": "Forgot Password",
    "name": "forgotpassword",
    "group": "Login",
    "parameter": {
      "fields": {
        "Login": [
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email Id ( Valid Email )  - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n     \"data\": {\n         \"message\": \"Reset Password Mail send successfully.\"\n     },\n     \"status\": true,\n     \"message\": \"Success\",\n     \"code\": 200\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - Invalid Input ( Email Missing ) :",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        },
        {
          "title": "Error-Response - User Not Found :",
          "content": "    {\n    \"error\": {\n        \"error\": \"User not Found !\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Login",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/forgotpassword"
      }
    ]
  },
  {
    "type": "post",
    "url": "login",
    "title": "Login-Nanny App",
    "name": "login",
    "group": "Login",
    "parameter": {
      "fields": {
        "Login": [
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email Id ( Valid Email )  - Required</p>"
          },
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>Password - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"userId\": 3,\n    \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTYyOTYwNSwiZXhwIjoxNTU3MTY1NjA1LCJuYmYiOjE1MjU2Mjk2MDUsImp0aSI6ImtSWkM2eWprc0w2aXBHNlQifQ.R2HL4t69E-vRboUKf9dlteEQwoJpc4Eb3I0tBlUkwGs\",\n    \"userType\": 1,\n    \"name\": \"Default User\",\n    \"mobile\": \"8000060541\",\n    \"deviceToken\": \"jlkjsaldkjfklasdf9384938409jklljlkjslkj\",\n    \"deviceType\": 1,\n    \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n    \"address\": \"Susmita Flat Vasna\",\n    \"city\": \"Ahmedabad\",\n    \"state\": \"Gujarat\",\n    \"zip\": \"380001\",\n    \"gender\": \"Male\",\n    \"birthday\": \"01/02/1992\",\n    \"status\": 1\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": \"Invalid Credentials\",\n    \"message\": \"No User Found for given details\",\n    \"status\": false\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Login",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/login"
      }
    ]
  },
  {
    "type": "post",
    "url": "user-profile",
    "title": "User Profile",
    "name": "user_profile",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Profile": [
          {
            "group": "Profile",
            "type": "integer",
            "optional": false,
            "field": "user_id",
            "description": "<p>User Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n     \"data\": {\n         \"userId\": 3,\n         \"userToken\": \"\",\n         \"userType\": 1,\n         \"name\": \"Default User\",\n         \"mobile\": \"\",\n         \"deviceToken\": \"jlkjsaldkjfklasdf9384938409jklljlkjslkj\",\n         \"deviceType\": 1,\n         \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n         \"address\": \"Susmita Flat Vasna\",\n         \"city\": \"Ahmedabad\",\n         \"state\": \"Gujarat\",\n         \"zip\": \"380001\",\n         \"gender\": \"Male\",\n         \"birthday\": \"01/02/1992\",\n         \"status\": 1\n     },\n     \"status\": true,\n     \"message\": \"Success\",\n     \"code\": 200\n }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - Invalid Input ( Email Missing ) :",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        },
        {
          "title": "Error-Response - User Not Found :",
          "content": "{\n    \"error\": {\n        \"error\": \"User not Found !\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Profile",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/user-profile"
      }
    ]
  },
  {
    "type": "post",
    "url": "register",
    "title": "Signup/Register-Nanny APp",
    "name": "register",
    "group": "Signup_Register",
    "parameter": {
      "fields": {
        "Register": [
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>User Name - Required</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>Email Id ( Valid Email )  - Required</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "mobile",
            "description": "<p>Mobile Contact - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "device_id",
            "description": "<p>Device Token - Optional</p>"
          },
          {
            "group": "Register",
            "type": "integer",
            "optional": false,
            "field": "device_type",
            "description": "<p>iOS/Android(1/2) - Optional</p>"
          },
          {
            "group": "Register",
            "type": "integer",
            "optional": false,
            "field": "user_type",
            "description": "<p>Parent/Sitter( 1 / 2) - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "gender",
            "description": "<p>Gender( Male / Female) - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "address",
            "description": "<p>User Address - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "city",
            "description": "<p>User City - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "state",
            "description": "<p>User State - Optional</p>"
          },
          {
            "group": "Register",
            "type": "integer",
            "optional": false,
            "field": "zip",
            "description": "<p>User Zip - Optional</p>"
          },
          {
            "group": "Register",
            "type": "date",
            "optional": false,
            "field": "birthdate",
            "description": "<p>User Birth Date - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "profile_pic",
            "description": "<p>User Avatar ( Image file ) - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"userId\": 13,\n    \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjEzLCJpc3MiOiJodHRwOlwvXC9uYW5ueS1hcHAubG9jYWxcL2FwaVwvcmVnaXN0ZXIiLCJpYXQiOjE1MjU2MzAxNDYsImV4cCI6MTU1NzE2NjE0NiwibmJmIjoxNTI1NjMwMTQ2LCJqdGkiOiJweGxEemU2RTkxeFhENmx5In0.PbYVLDL9T6nSumaC7X-biOtHMH7M09PqsHtC1Uc46-A\",\n    \"userType\": 1,\n    \"name\": \"Anuj Jaha\",\n    \"mobile\": \"8000060541\",\n    \"deviceToken\": \"\",\n    \"deviceType\": 1,\n    \"profilePic\": \"http://nanny-app.local/uploads/user/81778_user.\",\n    \"address\": \"test\",\n    \"city\": \"Abad\",\n    \"state\": \"Gujarat\",\n    \"zip\": \"389489\",\n    \"gender\": \"Male\",\n    \"birthday\": \"01/01/1991\",\n    \"status\": 1\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": {\n        \"email\": [\n            \"The email has already been taken.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"Failure\",\n    \"code\": 200\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": {\n        \"password\": [\n            \"The password field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"Failure\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Signup_Register",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/register"
      }
    ]
  }
] });
