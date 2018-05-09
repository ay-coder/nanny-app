define({ "api": [
  {
    "type": "get",
    "url": "babies",
    "title": "Babies List",
    "name": "babies",
    "group": "Babies",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"babiesId\": 1,\n            \"babiesParentId\": 3,\n            \"babiesTitle\": \"First Baby\",\n            \"babiesBirthdate\": \"08/30/2000\",\n            \"babiesAge\": 17,\n            \"babiesDescription\": \"this is test\",\n            \"babiesImage\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "title": "Create New Baby",
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
          "content": "{\n    \"data\": {\n        \"babiesId\": 5,\n        \"babiesParentId\": 3,\n        \"babiesTitle\": \"Test Baby\",\n        \"babiesBirthdate\": \"01/01/2005\",\n        \"babiesAge\": 13,\n        \"babiesDescription\": \"This is test Baby\",\n        \"babiesImage\": \"http://nanny-app.local/uploads/babies/default.png\"\n    },\n    \"status\": true,\n    \"message\": \"Babies is Created Successfully\",\n    \"code\": 200\n}",
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
    "title": "Delete Baby",
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
    "title": "Edit Baby Details",
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
          "content": "{\n    \"data\": {\n        \"babiesId\": 5,\n        \"babiesParentId\": 3,\n        \"babiesTitle\": \"New Name\",\n        \"babiesBirthdate\": \"01/01/2014\",\n        \"babiesAge\": 4,\n        \"babiesDescription\": \"This is test Baby.\",\n        \"babiesImage\": \"http://nanny-app.local/uploads/babies/default.png\"\n    },\n    \"status\": true,\n    \"message\": \"Baby is Edited Successfully\",\n    \"code\": 200\n}",
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
          "content": "    {\n    \"data\": {\n        \"userId\": 3,\n        \"userToken\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTg5MTk1NiwiZXhwIjoxNTU3NDI3OTU2LCJuYmYiOjE1MjU4OTE5NTYsImp0aSI6IjlBYlp3M3RobGZ4M2NVaksifQ.Zu8BSn9dOfQdoF2wcz1_HnY5jv9nvoAKqc7neVVWO6Y\",\n        \"email\": \"user@user.com\",\n        \"userType\": 1,\n        \"name\": \"Anuj Jaha\",\n        \"mobile\": \"\",\n        \"deviceToken\": \"asjdfjkl7676736\",\n        \"deviceType\": 2,\n        \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/02/1992\",\n        \"notificationCount\": 0,\n        \"profileCompletion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "url": "update-user-profile",
    "title": "Update User Profile",
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
          "content": "{\n    \"data\": {\n        \"userId\": 3,\n        \"userType\": 1,\n        \"name\": \"Anuj Jaha - 1\",\n        \"email\": \"user@user.com\",\n        \"mobile\": \"\",\n        \"deviceToken\": \"asjdfjkl7676736\",\n        \"deviceType\": 2,\n        \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthday\": \"01/02/1992\",\n        \"notificationCount\": 0,\n        \"profileCompletion\": 0,\n        \"status\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
          "content": "{\n     \"data\": {\n         \"userId\": 3,\n         \"userToken\": \"\",\n         \"email\": \"user@user.com\",\n         \"userType\": 1,\n         \"name\": \"Anuj Jaha\",\n         \"mobile\": \"\",\n         \"deviceToken\": \"asjdfjkl7676736\",\n         \"deviceType\": 2,\n         \"profilePic\": \"http://nanny-app.local/uploads/user/default.png\",\n         \"address\": \"Susmita Flat Vasna\",\n         \"city\": \"Ahmedabad\",\n         \"state\": \"Gujarat\",\n         \"zip\": \"380001\",\n         \"gender\": \"Male\",\n         \"birthday\": \"01/02/1992\",\n         \"notificationCount\": 0,\n         \"profileCompletion\": 0,\n         \"status\": 1\n     },\n     \"status\": true,\n     \"message\": \"Success\",\n     \"code\": 200\n }",
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
