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
          },
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "device_token",
            "description": "<p>Device-Token - Required</p>"
          },
          {
            "group": "Login",
            "type": "integer",
            "optional": false,
            "field": "device_type",
            "description": "<p>Device-Type ( 1 / 2) - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"userId\": 3,\n    \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTY2OTM0MCwiZXhwIjoxNTU3MjA1MzQwLCJuYmYiOjE1MjU2NjkzNDAsImp0aSI6InR1TG9Ra1czYkcxemI1Yk8ifQ.rAU83p-Wuc2SdI4RhqeMg2BkdyuSeS_sgemVR37mcVA\",\n    \"userType\": 1,\n    \"name\": \"Default User\",\n    \"mobile\": \"\",\n    \"deviceToken\": \"asjdfjkl7676736\",\n    \"deviceType\": 2,\n    \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n    \"address\": \"Susmita Flat Vasna\",\n    \"city\": \"Ahmedabad\",\n    \"state\": \"Gujarat\",\n    \"zip\": \"380001\",\n    \"gender\": \"Male\",\n    \"birthday\": \"01/02/1992\",\n    \"notificationCount\": 0,\n    \"profileCompletion\": 0,\n    \"status\": 1\n}",
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
          "content": "   {\n    \"userId\": 3,\n    \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTY2OTM0MCwiZXhwIjoxNTU3MjA1MzQwLCJuYmYiOjE1MjU2NjkzNDAsImp0aSI6InR1TG9Ra1czYkcxemI1Yk8ifQ.rAU83p-Wuc2SdI4RhqeMg2BkdyuSeS_sgemVR37mcVA\",\n    \"userType\": 1,\n    \"name\": \"Default User\",\n    \"mobile\": \"\",\n    \"deviceToken\": \"asjdfjkl7676736\",\n    \"deviceType\": 2,\n    \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n    \"address\": \"Susmita Flat Vasna\",\n    \"city\": \"Ahmedabad\",\n    \"state\": \"Gujarat\",\n    \"zip\": \"380001\",\n    \"gender\": \"Male\",\n    \"birthday\": \"01/02/1992\",\n    \"notificationCount\": 0,\n    \"profileCompletion\": 0,\n    \"status\": 1\n}",
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
          "content": "{\n    \"userId\": 3,\n    \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTY2OTM0MCwiZXhwIjoxNTU3MjA1MzQwLCJuYmYiOjE1MjU2NjkzNDAsImp0aSI6InR1TG9Ra1czYkcxemI1Yk8ifQ.rAU83p-Wuc2SdI4RhqeMg2BkdyuSeS_sgemVR37mcVA\",\n    \"userType\": 1,\n    \"name\": \"Default User\",\n    \"mobile\": \"\",\n    \"deviceToken\": \"asjdfjkl7676736\",\n    \"deviceType\": 2,\n    \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n    \"address\": \"Susmita Flat Vasna\",\n    \"city\": \"Ahmedabad\",\n    \"state\": \"Gujarat\",\n    \"zip\": \"380001\",\n    \"gender\": \"Male\",\n    \"birthday\": \"01/02/1992\",\n    \"notificationCount\": 0,\n    \"profileCompletion\": 0,\n    \"status\": 1\n}",
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
