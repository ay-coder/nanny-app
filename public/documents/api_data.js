define({ "api": [
  {
    "type": "get",
    "url": "babies",
    "title": "Babies List ( Need Headers)",
    "name": "babies",
    "group": "Babies",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"baby_id\": 8,\n        \"parent_id\": 3,\n        \"title\": \"my baby\",\n        \"birthdate\": \"01/01/2005\",\n        \"age\": 13,\n        \"description\": \"This is test Baby\",\n        \"image\": \"http://nanny-app.local/uploads/babies/default.png\"\n    },\n    \"status\": true,\n    \"message\": \"Babies is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Babies Found ):",
          "content": "   {\n    \"error\": {\n        \"message\": \"Unable to find Babies!\"\n    },\n    \"status\": false,\n    \"message\": \"No Babies Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Babies",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/babies"
      }
    ]
  },
  {
    "type": "post",
    "url": "babies/create",
    "title": "Create New Baby ( Need Headers)",
    "name": "babies_create",
    "group": "Babies",
    "parameter": {
      "fields": {
        "Babies": [
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Baby Name - Required</p>"
          },
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "birthdate",
            "description": "<p>Birth Date - Required</p>"
          },
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Special Instructions - Required</p>"
          },
          {
            "group": "Babies",
            "type": "file",
            "optional": false,
            "field": "image",
            "description": "<p>Baby Picture - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"baby_id\": 8,\n        \"parent_id\": 3,\n        \"title\": \"my baby\",\n        \"birthdate\": \"01/01/2005\",\n        \"age\": 13,\n        \"description\": \"This is test Baby\",\n        \"image\": \"http://nanny-app.local/uploads/babies/default.png\"\n    },\n    \"status\": true,\n    \"message\": \"Babies is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Babies Found ):",
          "content": "{\n     \"error\": {\n         \"title\": [\n             \"The title field is required.\"\n         ]\n     },\n     \"status\": false,\n     \"message\": \"The title field is required.\",\n     \"code\": 200\n }",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Babies",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/babies/create"
      }
    ]
  },
  {
    "type": "post",
    "url": "babies/delete",
    "title": "Delete Baby ( Need Headers)",
    "name": "babies_delete",
    "group": "Babies",
    "parameter": {
      "fields": {
        "Babies": [
          {
            "group": "Babies",
            "type": "integer",
            "optional": false,
            "field": "baby_id",
            "description": "<p>Baby Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"success\": \"Baby Deleted\"\n    },\n    \"status\": true,\n    \"message\": \"Baby is Deleted Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Babies Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Baby Not Found or Baby Already Deleted !\",\n    \"code\": 404\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Babies",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/babies/delete"
      }
    ]
  },
  {
    "type": "post",
    "url": "babies/edit",
    "title": "Edit Baby Details ( Need Headers)",
    "name": "babies_edit",
    "group": "Babies",
    "parameter": {
      "fields": {
        "Babies": [
          {
            "group": "Babies",
            "type": "integer",
            "optional": false,
            "field": "baby_id",
            "description": "<p>Baby Id - Required</p>"
          },
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "title",
            "description": "<p>Baby Name - Required</p>"
          },
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "birthdate",
            "description": "<p>Birth Date - Required</p>"
          },
          {
            "group": "Babies",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Special Instructions - Required</p>"
          },
          {
            "group": "Babies",
            "type": "file",
            "optional": false,
            "field": "image",
            "description": "<p>Baby Picture - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"baby_id\": 8,\n        \"parent_id\": 3,\n        \"title\": \"my baby\",\n        \"birthdate\": \"01/01/2005\",\n        \"age\": 13,\n        \"description\": \"This is test Baby\",\n        \"image\": \"http://nanny-app.local/uploads/babies/default.png\"\n    },\n    \"status\": true,\n    \"message\": \"Babies is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Babies Found ):",
          "content": "{\n    \"error\": {\n        \"baby_id\": [\n            \"The baby id field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The baby id field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Babies",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/babies/edit"
      }
    ]
  },
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNjE4OTM5OCwiZXhwIjoxNTU3NzI1Mzk4LCJuYmYiOjE1MjYxODkzOTgsImp0aSI6IjZUQ1gzUkF2M1A4OXpuWXEifQ.pzYX2psZW3YgTICK-uyh058sEzZmG7nT7Cd-3gMiE48\",\n        \"email\": \"user@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "type": "get",
    "url": "logout",
    "title": "Logout ( Need Headers)",
    "name": "logout",
    "group": "Logout",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"message\": \"User Logged out successfully.\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( User Not Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"User Not Found !\"\n    },\n    \"status\": false,\n    \"message\": \"User Not Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Logout",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/logout"
      }
    ]
  },
  {
    "type": "post",
    "url": "find-sitters",
    "title": "Find Sitters ( Need Headers)",
    "name": "find_sitters",
    "group": "Parent___Sitters",
    "parameter": {
      "fields": {
        "Parent - Sitters": [
          {
            "group": "Parent - Sitters",
            "type": "string",
            "optional": false,
            "field": "date",
            "description": "<p>Date - Required</p>"
          },
          {
            "group": "Parent - Sitters",
            "type": "string",
            "optional": false,
            "field": "start_time",
            "description": "<p>Start Time - Required</p>"
          },
          {
            "group": "Parent - Sitters",
            "type": "string",
            "optional": false,
            "field": "end_time",
            "description": "<p>End Time - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"sitter_id\": 1,\n            \"user_id\": 3,\n            \"category\": \"child\",\n            \"about_me\": \"test\",\n            \"description\": \"this is description\",\n            \"email\": \"user@user.com\",\n            \"name\": \"Anuj Jaha - 2\",\n            \"mobile\": \"1223\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"address\": \"Test - Susmita\",\n            \"city\": \"Ahmedabad\",\n            \"state\": \"Gujarat\",\n            \"zip\": \"380001\",\n            \"gender\": \"Female\",\n            \"birthday\": \"04/07/1992\",\n            \"avg_rating\": 2.35,\n            \"reviews\": [\n                {\n                    \"review_by_id\": 3,\n                    \"review_by\": \"Anuj Jaha - 2\",\n                    \"rating\": \"2.4\",\n                    \"description\": \"This is Awesome Developers \",\n                    \"review_by_image\": \"http://nanny-app.local/uploads/user/default.png\"\n                },\n                {\n                    \"review_by_id\": 5,\n                    \"review_by\": \"Anuj Jaha\",\n                    \"rating\": \"2.3\",\n                    \"description\": \"this is another review\",\n                    \"review_by_image\": \"http://nanny-app.local/uploads/user/57299_user.jpg\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Sitters Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Sitters!\"\n    },\n    \"status\": false,\n    \"message\": \"No Sitters Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Parent___Sitters",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/find-sitters"
      }
    ]
  },
  {
    "type": "post",
    "url": "update-password",
    "title": "Update Password ( Need Headers)",
    "name": "update_password",
    "group": "Profile",
    "parameter": {
      "fields": {
        "Profile": [
          {
            "group": "Profile",
            "type": "string",
            "optional": false,
            "field": "password",
            "description": "<p>User Password - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"message\": \"Password Updated successfully.\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - Invalid Input ( Email Missing ) :",
          "content": "{\n    \"error\": {\n        \"password\": [\n            \"The password field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The password field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Profile",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/update-password"
      }
    ]
  },
  {
    "type": "post",
    "url": "update-user-profile",
    "title": "Update User Profile ( Need Headers)",
    "name": "update_user_profile",
    "group": "Profile",
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
            "field": "mobile",
            "description": "<p>Mobile Contact - Optional</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "device_token",
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTgwMDk0OSwiZXhwIjoxNTU3MzM2OTQ5LCJuYmYiOjE1MjU4MDA5NDksImp0aSI6ImlEN3dKd3U4RUtyRHdUNUIifQ.JU2T_95oEEayz8pBQi_sQuqjlSJawo72Z9Tc7TiSaOc\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"email\": \"user@user.com\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": {\n        \"name\": [\n            \"The name field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The name field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Profile",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/update-user-profile"
      }
    ]
  },
  {
    "type": "post",
    "url": "user-profile",
    "title": "User Profile ( Need Headers)",
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"\",\n        \"email\": \"user@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
            "field": "password",
            "description": "<p>Password - Required</p>"
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
            "field": "device_token",
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
          "content": "{\n    \"data\": {\n        \"user_id\": 17,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE3LCJpc3MiOiJodHRwOlwvXC9uYW5ueS1hcHAubG9jYWxcL2FwaVwvcmVnaXN0ZXIiLCJpYXQiOjE1MjYxODk1NTEsImV4cCI6MTU1NzcyNTU1MSwibmJmIjoxNTI2MTg5NTUxLCJqdGkiOiJJU01HQm5DanVueW10d2xvIn0.lyD-X5aY_UiSxleKTaWnU8KRK6OJUVwE1Fb73F5CBU4\",\n        \"email\": \"use21r11111340@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha\",\n        \"mobile\": \"80000605541\",\n        \"device_token\": \"kjdljf738473\",\n        \"device_type\": 1,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"test\",\n        \"city\": \"Abad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"389489\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/01/1991\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": {\n        \"email\": [\n            \"The email has already been taken.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The email has already been taken.\",\n    \"code\": 200\n}",
          "type": "json"
        },
        {
          "title": "Error-Response:",
          "content": "{\n    \"error\": {\n        \"password\": [\n            \"The password field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The password field is required.\",\n    \"code\": 200\n}",
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
