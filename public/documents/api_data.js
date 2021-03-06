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
    "type": "get",
    "url": "booking",
    "title": "User Bookings ( Headers Needed)",
    "name": "booking",
    "group": "Booking",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    {\n    \"data\": [\n        {\n            \"booking_id\": 1,\n            \"user_id\": 1,\n            \"sitter_id\": 1,\n            \"sitter_name\": \"Admin Istrator\",\n            \"sitter_contact\": \"8000060541\",\n            \"sitter_rating\": \"2.33\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-05-24\",\n            \"start_time\": \"10:23:17\",\n            \"end_time\": \"10:23:19\",\n            \"booking_startime\": \"2018-05-24 08:17:18\",\n            \"booking_endtime\": \"2018-05-24 08:22:22\",\n            \"booking_status\": \"PENDING\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                },\n                {\n                    \"baby_id\": 4,\n                    \"title\": \"New Name\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/40242_baby.\"\n                },\n                {\n                    \"baby_id\": 5,\n                    \"title\": \"New Name\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/default.png\"\n                },\n                {\n                    \"baby_id\": 6,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/default.png\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 2,\n            \"user_id\": 3,\n            \"sitter_id\": 1,\n            \"sitter_name\": \"Admin Istrator\",\n            \"sitter_rating\": \"2.33\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\":\"2018-01-01 10:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 3,\n            \"user_id\": 3,\n            \"sitter_id\": 1,\n            \"sitter_name\": \"Admin Istrator\",\n            \"sitter_rating\": \"2.33\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 11:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 4,\n            \"user_id\": 3,\n            \"sitter_id\": 1,\n            \"sitter_name\": \"Admin Istrator\",\n            \"sitter_rating\": \"2.33\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 11:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                }\n            ]\n        },\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - User Not Found :",
          "content": "    {\n        \"error\": {\n            \"error\": \"User not Found !\"\n        },\n        \"status\": false,\n        \"message\": \"Something went wrong !\",\n        \"code\": 400\n    }\n\n\n*",
          "type": "json"
        },
        {
          "title": "Error-Response - Booking Not Found :",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Booking",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/create",
    "title": "Create New Booking ( Need Headers)",
    "name": "booking_create",
    "group": "Booking",
    "parameter": {
      "fields": {
        "Booking": [
          {
            "group": "Booking",
            "type": "integer",
            "optional": false,
            "field": "sitter_id",
            "description": "<p>Sitter ID - Required</p>"
          },
          {
            "group": "Booking",
            "type": "integer",
            "optional": false,
            "field": "baby_id",
            "description": "<p>Baby ID - Required</p>"
          },
          {
            "group": "Booking",
            "type": "string",
            "optional": false,
            "field": "booking_date",
            "description": "<p>Booking Date - Required</p>"
          },
          {
            "group": "Booking",
            "type": "string",
            "optional": false,
            "field": "start_time",
            "description": "<p>Start Time - Required</p>"
          },
          {
            "group": "Booking",
            "type": "string",
            "optional": false,
            "field": "end_time",
            "description": "<p>End Time - Required</p>"
          },
          {
            "group": "Booking",
            "type": "integer",
            "optional": false,
            "field": "is_multiple",
            "description": "<p>Is Multiple ( Flag 0/1) - Optional</p>"
          },
          {
            "group": "Booking",
            "type": "string",
            "optional": false,
            "field": "baby_ids",
            "description": "<p>Multiple Baby Ids ( like 1,2,3) - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"booking_id\": 8,\n        \"user_id\": 3,\n        \"sitter_id\": 1,\n        \"sitter_name\": \"Admin Istrator\",\n        \"sitter_rating\": \"2.33\",\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"baby_id\": \"1\",\n        \"is_multiple\": \"1\",\n        \"booking_date\": \"2018-01-01\",\n        \"start_time\": \"10:50\",\n        \"end_time\": \"12:50\",\n        \"booking_startime\": \"2018-01-01 10:50:00\",\n        \"booking_endtime\": \"2018-01-01 12:50:00\",\n        \"booking_status\": \"REQUESTED\",\n        \"babies\": [\n            {\n                \"baby_id\": 1,\n                \"title\": \"New Name - updatd\",\n                \"birthdate\": \"01/01/2014\",\n                \"age\": 4,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n            },\n            {\n                \"baby_id\": 1,\n                \"title\": \"New Name - updatd\",\n                \"birthdate\": \"01/01/2014\",\n                \"age\": 4,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n            },\n            {\n                \"baby_id\": 3,\n                \"title\": \"Anuj New Name\",\n                \"birthdate\": \"01/01/1992\",\n                \"age\": 26,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n            }\n        ]\n    },\n    \"status\": true,\n    \"message\": \"Booking is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( Validation Error ):",
          "content": "    {\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Booking",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/create"
      }
    ]
  },
  {
    "type": "get",
    "url": "past-booking",
    "title": "User Past Bookings ( Headers Needed)",
    "name": "past_booking",
    "group": "Booking",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    {\n    \"data\": [\n        {\n            \"booking_id\": 1,\n            \"user_id\": 1,\n            \"sitter_id\": 3,\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"1223\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/24519_user.jpg\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-05-24\",\n            \"start_time\": \"10:23:17\",\n            \"end_time\": \"10:23:19\",\n            \"booking_startime\": \"2018-05-24 08:17:18\",\n            \"booking_endtime\": \"2018-05-24 08:22:22\",\n            \"booking_status\": \"COMPLETED\",\n            \"total_cost\": 10,\n            \"tax\": 2,\n            \"additional_fees\": 5,\n            \"other_charges\": 3,\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - User Not Found :",
          "content": "    {\n        \"error\": {\n            \"error\": \"User not Found !\"\n        },\n        \"status\": false,\n        \"message\": \"Something went wrong !\",\n        \"code\": 400\n    }\n\n\n*",
          "type": "json"
        },
        {
          "title": "Error-Response - Booking Not Found :",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Booking",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/past-booking"
      }
    ]
  },
  {
    "type": "get",
    "url": "config",
    "title": "Config ( No Headers Needed)",
    "name": "config",
    "group": "Config",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"support_number\": \"110001010\",\n        \"privacy_policy_url\": \"https://www.google.co.in/\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Config",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/config"
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNjE4OTM5OCwiZXhwIjoxNTU3NzI1Mzk4LCJuYmYiOjE1MjYxODkzOTgsImp0aSI6IjZUQ1gzUkF2M1A4OXpuWXEifQ.pzYX2psZW3YgTICK-uyh058sEzZmG7nT7Cd-3gMiE48\",\n        \"email\": \"user@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "url": "social-login",
    "title": "Social Login",
    "name": "social_login",
    "group": "Login",
    "parameter": {
      "fields": {
        "Login": [
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "social_provider",
            "description": "<p>Provider ( Gmail / Facebook ) - Required</p>"
          },
          {
            "group": "Login",
            "type": "string",
            "optional": false,
            "field": "social_token",
            "description": "<p>Social Media Token ( Valid Token )  - Required</p>"
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNjE4OTM5OCwiZXhwIjoxNTU3NzI1Mzk4LCJuYmYiOjE1MjYxODkzOTgsImp0aSI6IjZUQ1gzUkF2M1A4OXpuWXEifQ.pzYX2psZW3YgTICK-uyh058sEzZmG7nT7Cd-3gMiE48\",\n        \"email\": \"user@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
        "url": "http://35.154.84.230/nanny/public/api/social-login"
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
    "type": "get",
    "url": "messages",
    "title": "Get All Message ( Need Headers)",
    "name": "messages",
    "group": "Message",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"message_id\": 10,\n            \"from_user_id\": 3,\n            \"from_user_name\": \"Anuj Jaha - 2\",\n            \"to_user_id\": 1,\n            \"to_user_name\": \"Admin Istrator\",\n            \"image\": \"http://nanny-app.local/uploads/babies/16143_message.jpg\",\n            \"message\": \"This is testing\",\n            \"is_image\": 1,\n            \"is_read\": 0,\n            \"is_sender\": 1,\n            \"message_time\": \"17-05-2018 18:24 PM\"\n        },\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Messages ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Messages!\"\n    },\n    \"status\": false,\n    \"message\": \"No Messages Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/messages"
      }
    ]
  },
  {
    "type": "post",
    "url": "messages/create",
    "title": "Create Message ( Need Headers)",
    "name": "messages_create",
    "group": "Message",
    "parameter": {
      "fields": {
        "Message": [
          {
            "group": "Message",
            "type": "integer",
            "optional": false,
            "field": "to_user_id",
            "description": "<p>TO User Id - Required</p>"
          },
          {
            "group": "Message",
            "type": "string",
            "optional": false,
            "field": "message",
            "description": "<p>Message - Optional</p>"
          },
          {
            "group": "Message",
            "type": "file",
            "optional": false,
            "field": "image",
            "description": "<p>Image - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"message_id\": 10,\n        \"from_user_id\": 3,\n        \"from_user_name\": \"Anuj Jaha - 2\",\n        \"to_user_id\": \"1\",\n        \"to_user_name\": \"Admin Istrator\",\n        \"image\": \"http://nanny-app.local/uploads/babies/16143_message.jpg\",\n        \"message\": \"This is testing\",\n        \"is_image\": 1,\n        \"is_read\": 0,\n        \"is_sender\": 1,\n        \"message_time\": \"21-05-2018 04:23 AM\"\n    },\n    \"status\": true,\n    \"message\": \"Messages is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( Validation Error ):",
          "content": "{\n    \"error\": {\n        \"to_user_id\": [\n            \"The to user id field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The to user id field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Message",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/messages/create"
      }
    ]
  },
  {
    "type": "post",
    "url": "requests/create",
    "title": "Create Nanny Requests( Need Headers)",
    "name": "requests_create",
    "group": "Nanny_Requests",
    "parameter": {
      "fields": {
        "Requests": [
          {
            "group": "Requests",
            "type": "string",
            "optional": false,
            "field": "user_request",
            "description": "<p>User Request - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"request_id\": 3,\n        \"user_id\": 3,\n        \"user_request\": \"this is testing\"\n    },\n    \"status\": true,\n    \"message\": \"Requests is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - User Not Found :",
          "content": "{\n    \"error\": {\n        \"user_request\": [\n            \"The user request field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The user request field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Nanny_Requests",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/requests/create"
      }
    ]
  },
  {
    "type": "get",
    "url": "notifications",
    "title": "User Notifications ( Headers Needed)",
    "name": "notifications",
    "group": "Notifications",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"notification_id\": 1,\n            \"user_id\": 3,\n            \"user_name\": \"Anuj Jaha - 2\",\n            \"sitter_id\": 2,\n            \"sitter_name\": \"Backend User\",\n            \"icon\": \"http://nanny-app.local/uploads/notifications/default.png\",\n            \"description\": \"Job Done\",\n            \"is_read\": 0,\n            \"read_time\": \"\",\n            \"created_at\": \"01-01-1970 00:00 AM\"\n        },\n        {\n            \"notification_id\": 2,\n            \"user_id\": 3,\n            \"user_name\": \"Anuj Jaha - 2\",\n            \"sitter_id\": 5,\n            \"sitter_name\": \"Anuj Jaha\",\n            \"icon\": \"http://nanny-app.local/uploads/notifications/default.png\",\n            \"description\": \"Job Started\",\n            \"is_read\": 0,\n            \"read_time\": \"\",\n            \"created_at\": \"01-01-1970 00:00 AM\"\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response - User Not Found :",
          "content": "{\n    \"error\": {\n        \"error\": \"User not Found !\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Notifications",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/notifications"
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
          "content": "{\n    \"data\": [\n        {\n            \"sitter_id\": 1,\n            \"user_id\": 3,\n            \"category\": \"child\",\n            \"about_me\": \"test\",\n            \"description\": \"this is description\",\n            \"email\": \"user@user.com\",\n            \"name\": \"Anuj Jaha - 2\",\n            \"mobile\": \"1223\",\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"address\": \"Test - Susmita\",\n            \"city\": \"Ahmedabad\",\n            \"state\": \"Gujarat\",\n            \"zip\": \"380001\",\n            \"gender\": \"Female\",\n            \"birthdate\": \"04/07/1992\",\n            \"avg_rating\": 2.35,\n            \"reviews\": [\n                {\n                    \"review_by_id\": 3,\n                    \"review_by\": \"Anuj Jaha - 2\",\n                    \"rating\": \"2.4\",\n                    \"description\": \"This is Awesome Developers \",\n                    \"review_by_image\": \"http://nanny-app.local/uploads/user/default.png\"\n                },\n                {\n                    \"review_by_id\": 5,\n                    \"review_by\": \"Anuj Jaha\",\n                    \"rating\": \"2.3\",\n                    \"description\": \"this is another review\",\n                    \"review_by_image\": \"http://nanny-app.local/uploads/user/57299_user.jpg\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "url": "sitters/show",
    "title": "Show Single Sitter ( Need Headers)",
    "name": "sitters_show",
    "group": "Parent___Sitters",
    "parameter": {
      "fields": {
        "Parent - Sitters": [
          {
            "group": "Parent - Sitters",
            "type": "integer",
            "optional": false,
            "field": "sitter_id",
            "description": "<p>Sitter Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"sitter_id\": 1,\n        \"user_id\": 3,\n        \"category\": \"Baby Child\",\n        \"about_me\": \"This is aboute me test.\",\n        \"description\": \"Thisi s descrition\",\n        \"email\": \"user@user.com\",\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"1223\",\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/24519_user.jpg\",\n        \"address\": \"Test - Susmita\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Female\",\n        \"birthday\": \"04/07/1992\",\n        \"avg_rating\": 2.325,\n        \"reviews\": [\n            {\n                \"review_by_id\": 3,\n                \"review_by\": \"Anuj Jaha - 2\",\n                \"rating\": \"2.4\",\n                \"description\": \"This is Awesome Developers \",\n                \"review_by_image\": \"http://nanny-app.local/uploads/user/24519_user.jpg\"\n            },\n            {\n                \"review_by_id\": 5,\n                \"review_by\": \"Anuj Jaha\",\n                \"rating\": \"2.3\",\n                \"description\": \"this is another review\",\n                \"review_by_image\": \"http://nanny-app.local/uploads/user/57299_user.jpg\"\n            },\n            {\n                \"review_by_id\": 3,\n                \"review_by\": \"Anuj Jaha - 2\",\n                \"rating\": \"2.3\",\n                \"description\": \"this is teston\",\n                \"review_by_image\": \"http://nanny-app.local/uploads/user/24519_user.jpg\"\n            },\n            {\n                \"review_by_id\": 3,\n                \"review_by\": \"Anuj Jaha - 2\",\n                \"rating\": \"2.3\",\n                \"description\": \"this is teston\",\n                \"review_by_image\": \"http://nanny-app.local/uploads/user/24519_user.jpg\"\n            }\n        ]\n    },\n    \"status\": true,\n    \"message\": \"View Item\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( No Sitters Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs or Item not exists !\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Parent___Sitters",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/show"
      }
    ]
  },
  {
    "type": "get",
    "url": "profile-completion",
    "title": "Profile Completion ( Headers Required)",
    "name": "profile_completion",
    "group": "Profile",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "    {\n\t    \"data\": {\n\t        \"name\": true,\n\t        \"gender\": true,\n\t        \"mobile\": true,\n\t        \"address\": true,\n\t        \"birthdate\": true,\n\t        \"profile_completion_count\": 100\n\t    },\n\t    \"status\": true,\n\t    \"message\": \"Success\",\n\t    \"code\": 200\n\t}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Plan Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Plans!\"\n    },\n    \"status\": false,\n    \"message\": \"No Plans Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Profile",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/profile-completion"
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjMsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9sb2dpbiIsImlhdCI6MTUyNTgwMDk0OSwiZXhwIjoxNTU3MzM2OTQ5LCJuYmYiOjE1MjU4MDA5NDksImp0aSI6ImlEN3dKd3U4RUtyRHdUNUIifQ.JU2T_95oEEayz8pBQi_sQuqjlSJawo72Z9Tc7TiSaOc\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"email\": \"user@user.com\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
          "content": "{\n    \"data\": {\n        \"user_id\": 3,\n        \"user_token\": \"\",\n        \"email\": \"user@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"asjdfjkl7676736\",\n        \"device_type\": 2,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"Susmita Flat Vasna\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/02/1992\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "url": "reviews/create",
    "title": "Create Review ( Need Headers)",
    "name": "reviews_create",
    "group": "Reviews",
    "parameter": {
      "fields": {
        "Reviews": [
          {
            "group": "Reviews",
            "type": "integer",
            "optional": false,
            "field": "sitter_id",
            "description": "<p>Sitter Id - Required</p>"
          },
          {
            "group": "Reviews",
            "type": "integer",
            "optional": false,
            "field": "rating",
            "description": "<p>Rating - Required</p>"
          },
          {
            "group": "Reviews",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Description - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"review_id\": 4,\n        \"user_id\": 3,\n        \"sitter_id\": \"1\",\n        \"rating\": \"2.3\",\n        \"description\": \"this is teston\"\n    },\n    \"status\": true,\n    \"message\": \"Reviews is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( Validation Error ):",
          "content": "{\n    \"error\": {\n        \"sitter_id\": [\n            \"The sitter id field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The sitter id field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Reviews",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/reviews/create"
      }
    ]
  },
  {
    "type": "post",
    "url": "reviews/create",
    "title": "Create Review ( Need Headers)",
    "name": "reviews_create",
    "group": "Reviews",
    "parameter": {
      "fields": {
        "Reviews": [
          {
            "group": "Reviews",
            "type": "integer",
            "optional": false,
            "field": "sitter_id",
            "description": "<p>Sitter Id - Required</p>"
          },
          {
            "group": "Reviews",
            "type": "integer",
            "optional": false,
            "field": "rating",
            "description": "<p>Rating - Required</p>"
          },
          {
            "group": "Reviews",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Description - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"review_id\": 4,\n        \"user_id\": 3,\n        \"sitter_id\": \"1\",\n        \"rating\": \"2.3\",\n        \"description\": \"this is test review\"\n    },\n    \"status\": true,\n    \"message\": \"Reviews is Created Successfully\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( Validation Error ):",
          "content": "{\n    \"error\": {\n        \"sitter_id\": [\n            \"The sitter id field is required.\"\n        ]\n    },\n    \"status\": false,\n    \"message\": \"The sitter id field is required.\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Reviews",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/reviews/create"
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
          "content": "{\n    \"data\": {\n        \"user_id\": 17,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE3LCJpc3MiOiJodHRwOlwvXC9uYW5ueS1hcHAubG9jYWxcL2FwaVwvcmVnaXN0ZXIiLCJpYXQiOjE1MjYxODk1NTEsImV4cCI6MTU1NzcyNTU1MSwibmJmIjoxNTI2MTg5NTUxLCJqdGkiOiJJU01HQm5DanVueW10d2xvIn0.lyD-X5aY_UiSxleKTaWnU8KRK6OJUVwE1Fb73F5CBU4\",\n        \"email\": \"use21r11111340@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha\",\n        \"mobile\": \"80000605541\",\n        \"device_token\": \"kjdljf738473\",\n        \"device_type\": 1,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"test\",\n        \"city\": \"Abad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"389489\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/01/1991\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
  },
  {
    "type": "post",
    "url": "social-register",
    "title": "Social Signup -Nanny APp",
    "name": "social_register",
    "group": "Signup_Register",
    "parameter": {
      "fields": {
        "Register": [
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "email",
            "description": "<p>User Email ( Valid Email) - Required</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "social_provider",
            "description": "<p>Social Provider (Gmail, Facebook) - Required</p>"
          },
          {
            "group": "Register",
            "type": "string",
            "optional": false,
            "field": "social_token",
            "description": "<p>Social Provider Token (Valid Token) - Required</p>"
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
            "field": "name",
            "description": "<p>User Name - Optional</p>"
          },
          {
            "group": "Register",
            "type": "integer",
            "optional": false,
            "field": "gender",
            "description": "<p>User Gender - Optional</p>"
          },
          {
            "group": "Register",
            "type": "integer",
            "optional": false,
            "field": "birthdate",
            "description": "<p>Birth date - Optional</p>"
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
          "content": "{\n    \"data\": {\n        \"user_id\": 17,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjE3LCJpc3MiOiJodHRwOlwvXC9uYW5ueS1hcHAubG9jYWxcL2FwaVwvcmVnaXN0ZXIiLCJpYXQiOjE1MjYxODk1NTEsImV4cCI6MTU1NzcyNTU1MSwibmJmIjoxNTI2MTg5NTUxLCJqdGkiOiJJU01HQm5DanVueW10d2xvIn0.lyD-X5aY_UiSxleKTaWnU8KRK6OJUVwE1Fb73F5CBU4\",\n        \"email\": \"use21r11111340@user.com\",\n        \"user_type\": 1,\n        \"name\": \"Anuj Jaha\",\n        \"mobile\": \"80000605541\",\n        \"device_token\": \"kjdljf738473\",\n        \"device_type\": 1,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"test\",\n        \"city\": \"Abad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"389489\",\n        \"gender\": \"Male\",\n        \"birthdate\": \"01/01/1991\",\n        \"notification_count\": 0,\n        \"profile_completion\": 0,\n        \"status\": 1,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
        "url": "http://35.154.84.230/nanny/public/api/social-register"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/accept",
    "title": "Accept Booking - Sitter App",
    "name": "booking_accept",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n        \"data\": {\n            \"success\": \"Booking Accepted by Sitter\"\n        },\n        \"status\": true,\n        \"message\": \"Booking Accepted by Sitter\",\n        \"code\": 200\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/accept"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/cancel",
    "title": "Cancel Booking - Sitter App",
    "name": "booking_cancel",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n        \"data\": {\n            \"success\": \"Booking Canceled by Sitter\"\n        },\n        \"status\": true,\n        \"message\": \"Booking Canceled by Sitter\",\n        \"code\": 200\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/cancel"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/reject",
    "title": "Reject Booking - Sitter App",
    "name": "booking_reject",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n        \"data\": {\n            \"success\": \"Booking Rejected by Sitter\"\n        },\n        \"status\": true,\n        \"message\": \"Booking Rejected by Sitter\",\n        \"code\": 200\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/reject"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/start",
    "title": "Start Booking - Sitter App",
    "name": "booking_start",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          },
          {
            "group": "Sitter",
            "type": "datetime",
            "optional": false,
            "field": "booking_start_time",
            "description": "<p>Booking Start Time ( Y-m-d H:i:s) - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n    \"data\": {\n        \"success\": \"Booking Started by Sitter\"\n    },\n    \"status\": true,\n    \"message\": \"Booking Started by Sitter\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/start"
      }
    ]
  },
  {
    "type": "post",
    "url": "booking/stop",
    "title": "Stop Booking - Sitter App",
    "name": "booking_stop",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          },
          {
            "group": "Sitter",
            "type": "datetime",
            "optional": false,
            "field": "booking_end_time",
            "description": "<p>Booking End Time ( Y-m-d H:i:s) - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n\n{\n        \"data\": {\n            \"success\": \"Booking Completed by Sitter\"\n        },\n        \"status\": true,\n        \"message\": \"Booking Completed by Sitter\",\n        \"code\": 200\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/booking/stop"
      }
    ]
  },
  {
    "type": "post",
    "url": "change-password",
    "title": "Change Password - Sitter App",
    "name": "change_password",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Password": [
          {
            "group": "Password",
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
          "content": "\n {\n    \"data\": {\n        \"message\": \"Password Updated successfully.\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Plan Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/change-password"
      }
    ]
  },
  {
    "type": "post",
    "url": "sitter-login",
    "title": "Login-Sitter App",
    "name": "sitter_login",
    "group": "Sitter",
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
          "content": "{\n    \"data\": {\n        \"user_id\": 2,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9zaXR0ZXItbG9naW4iLCJpYXQiOjE1MzE3MTgyNzksImV4cCI6MTU2MzI1NDI3OSwibmJmIjoxNTMxNzE4Mjc5LCJqdGkiOiJJNEl5NXJvWW9mMEpzMG9yIn0.Nu8WV_zWQFKfaVkui6mI3g2_hYDSL0k6Ata8wJEh0aw\",\n        \"email\": \"executive@executive.com\",\n        \"user_type\": 0,\n        \"name\": \"Backend User\",\n        \"mobile\": \"\",\n        \"device_token\": \"\",\n        \"device_type\": 0,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"\",\n        \"city\": \"\",\n        \"state\": \"\",\n        \"zip\": \"\",\n        \"gender\": \"\",\n        \"birthdate\": \"\",\n        \"notification_count\": 0,\n        \"profile_completion\": 20,\n        \"status\": 1,\n        \"baby_count\": 0,\n        \"social_provider\": \"\",\n        \"social_token\": \"\",\n        \"vacation_mode\": 1\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
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
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitter-login"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitter-profile",
    "title": "Sitter Profile - Sitter App",
    "name": "sitter_profile",
    "group": "Sitter",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"user_id\": 2,\n        \"user_token\": \"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJzdWIiOjIsImlzcyI6Imh0dHA6XC9cL25hbm55LWFwcC5sb2NhbFwvYXBpXC9zaXR0ZXItbG9naW4iLCJpYXQiOjE1MzE4NDk1MDgsImV4cCI6MTU2MzM4NTUwOCwibmJmIjoxNTMxODQ5NTA4LCJqdGkiOiJvRzByV0pwbWpGMXdBbVB2In0.-w1R2N6rJ3wVxdbojzBwk_beV_39l1X_v7BM4Bt62Oc\",\n        \"email\": \"executive@executive.com\",\n        \"about_me\": \"1\",\n        \"category\": \"Baby Child\",\n        \"vacation_mode\": 1,\n        \"description\": \"Thisi s descrition\",\n        \"sitter_start_time\": \"06:15:00\",\n        \"sitter_end_time\": \"18:25:00\",\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"\",\n        \"device_type\": 0,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"\",\n        \"city\": \"\",\n        \"state\": \"\",\n        \"zip\": \"\",\n        \"gender\": \"\",\n        \"birthdate\": \"\",\n        \"notification_count\": 0,\n        \"profile_completion\": 20,\n        \"status\": 1,\n        \"baby_count\": 0,\n        \"social_provider\": \"\",\n        \"social_token\": \"\",\n        \"user_type \": 2\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitter-profile"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitters/active-bookings",
    "title": "Active Bookings - Sitter App",
    "name": "sitters_active_bookings",
    "group": "Sitter",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n    {\n    \"data\": [\n        {\n            \"booking_id\": 1,\n            \"user_id\": 1,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-05-24\",\n            \"start_time\": \"10:23:17\",\n            \"end_time\": \"10:23:19\",\n            \"booking_startime\": \"2018-05-24 08:17:18\",\n            \"booking_endtime\": \"2018-05-24 08:22:22\",\n            \"booking_status\": \"COMPLETED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 3,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": null,\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 8,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 10:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/active-bookings"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitters/add-timings",
    "title": "Add Work Timings - Sitter App",
    "name": "sitters_add_timings",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "time",
            "optional": false,
            "field": "sitter_start_time",
            "description": "<p>Start Time (06:15) - Required</p>"
          },
          {
            "group": "Sitter",
            "type": "time",
            "optional": false,
            "field": "sitter_end_time",
            "description": "<p>End Time (18:30) - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": {\n        \"success\": \"Sitter Timings Updated\"\n    },\n    \"status\": true,\n    \"message\": \"Updated Sitter Timings\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Sitter Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/add-timings"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitters/calendar",
    "title": "Get Calendar ( Headers Required)",
    "name": "sitters_calendar",
    "group": "Sitter",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"booking_id\": 1,\n            \"user_id\": 1,\n            \"sitter_id\": 2,\n            \"sitter_name\": \"Backend User\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-05-24\",\n            \"start_time\": \"10:23:17\",\n            \"end_time\": \"10:23:19\",\n            \"booking_startime\": \"2018-05-24 08:17:18\",\n            \"booking_endtime\": \"2018-05-24 08:22:22\",\n            \"booking_status\": \"COMPLETED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 3,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"sitter_name\": \"Backend User\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": null,\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 6,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"sitter_name\": \"Backend User\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 10:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 8,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"sitter_name\": \"Backend User\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 10:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Plan Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Sitter!\"\n    },\n    \"status\": false,\n    \"message\": \"No Sitter Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/calendar"
      }
    ]
  },
  {
    "type": "post",
    "url": "sitters/get-booking",
    "title": "Single Booking - Sitter App",
    "name": "sitters_get_booking",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Sitter": [
          {
            "group": "Sitter",
            "type": "integer",
            "optional": false,
            "field": "booking_id",
            "description": "<p>Booking Id - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n\n{\n    \"data\": {\n        \"booking_id\": 4,\n        \"user_id\": 3,\n        \"sitter_id\": 2,\n        \"user_name\": \"Anuj Jaha - 3\",\n        \"sitter_name\": \"Anuj Jaha - 2\",\n        \"sitter_contact\": \"\",\n        \"sitter_rating\": 0,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"user_profile_pic\": \"http://nanny-app.local/uploads/user/24519_user.jpg\",\n        \"baby_id\": 1,\n        \"is_multiple\": 1,\n        \"booking_date\": \"2018-01-01\",\n        \"start_time\": \"10:50:00\",\n        \"end_time\": \"12:50:00\",\n        \"booking_startime\": \"2018-07-19 11:25:00\",\n        \"booking_endtime\": \"2018-07-19 14:25:00\",\n        \"booking_status\": \"COMPLETED\",\n        \"address\": \"Test - Susmita\",\n        \"city\": \"Ahmedabad\",\n        \"state\": \"Gujarat\",\n        \"zip\": \"380001\",\n        \"babies\": [\n            {\n                \"baby_id\": 1,\n                \"title\": \"New Name - updatd\",\n                \"birthdate\": \"01/01/2014\",\n                \"age\": 4,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n            },\n            {\n                \"baby_id\": 1,\n                \"title\": \"New Name - updatd\",\n                \"birthdate\": \"01/01/2014\",\n                \"age\": 4,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n            },\n            {\n                \"baby_id\": 3,\n                \"title\": \"Anuj New Name\",\n                \"birthdate\": \"01/01/1992\",\n                \"age\": 26,\n                \"description\": \"This is test Baby.\",\n                \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n            }\n        ],\n        \"payment\": {\n            \"payment_id\": 3,\n            \"per_hour\": 10,\n            \"total_hour\": 3,\n            \"sub_total\": 30,\n            \"tax\": 0,\n            \"other_charges\": 0,\n            \"parking_fees\": 0,\n            \"total\": 30,\n            \"description\": \"Test Mode - Payment\",\n            \"payment_status\": \"\",\n            \"payment_via\": \"\",\n            \"payment_details\": \"\"\n        }\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/get-booking"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitters/my-earnings",
    "title": "Sitter Earnings - Sitter App",
    "name": "sitters_my_earnings",
    "group": "Sitter",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n\n{\n    \"data\": {\n        \"total_earning\": 70,\n        \"bookings\": [\n            {\n                \"booking_id\": 1,\n                \"user_id\": 1,\n                \"sitter_id\": 2,\n                \"user_name\": \"Admin Istrator\",\n                \"sitter_name\": \"Anuj Jaha - 2\",\n                \"sitter_contact\": \"\",\n                \"sitter_rating\": 0,\n                \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n                \"user_profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n                \"baby_id\": 1,\n                \"is_multiple\": 0,\n                \"booking_date\": \"2018-05-24\",\n                \"start_time\": \"10:23:17\",\n                \"end_time\": \"10:23:19\",\n                \"booking_startime\": \"2018-05-24 08:17:18\",\n                \"booking_endtime\": \"2018-05-24 08:22:22\",\n                \"booking_status\": \"COMPLETED\",\n                \"address\": \"Ahmedabad\\r\\n\",\n                \"city\": \"\",\n                \"state\": \"\",\n                \"zip\": \"\",\n                \"babies\": [\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    }\n                ],\n                \"payment\": []\n            },\n            {\n                \"booking_id\": 3,\n                \"user_id\": 3,\n                \"sitter_id\": 2,\n                \"user_name\": \"Anuj Jaha - 3\",\n                \"sitter_name\": \"Anuj Jaha - 2\",\n                \"sitter_contact\": \"\",\n                \"sitter_rating\": 0,\n                \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n                \"user_profile_pic\": \"http://nanny-app.local/uploads/user/24519_user.jpg\",\n                \"baby_id\": 1,\n                \"is_multiple\": 0,\n                \"booking_date\": \"2018-01-01\",\n                \"start_time\": \"10:50:00\",\n                \"end_time\": \"12:50:00\",\n                \"booking_startime\": \"2018-07-19 11:25:00\",\n                \"booking_endtime\": \"2018-07-19 15:25:00\",\n                \"booking_status\": \"COMPLETED\",\n                \"address\": \"Test - Susmita\",\n                \"city\": \"Ahmedabad\",\n                \"state\": \"Gujarat\",\n                \"zip\": \"380001\",\n                \"babies\": [\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    },\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    }\n                ],\n                \"payment\": {\n                    \"payment_id\": 4,\n                    \"per_hour\": 10,\n                    \"total_hour\": 4,\n                    \"sub_total\": 40,\n                    \"tax\": 0,\n                    \"other_charges\": 0,\n                    \"parking_fees\": 0,\n                    \"total\": 40,\n                    \"description\": \"Test Mode - Payment\",\n                    \"payment_status\": 0,\n                    \"payment_via\": \"\",\n                    \"payment_details\": \"\"\n                }\n            },\n            {\n                \"booking_id\": 4,\n                \"user_id\": 3,\n                \"sitter_id\": 2,\n                \"user_name\": \"Anuj Jaha - 3\",\n                \"sitter_name\": \"Anuj Jaha - 2\",\n                \"sitter_contact\": \"\",\n                \"sitter_rating\": 0,\n                \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n                \"user_profile_pic\": \"http://nanny-app.local/uploads/user/24519_user.jpg\",\n                \"baby_id\": 1,\n                \"is_multiple\": 1,\n                \"booking_date\": \"2018-01-01\",\n                \"start_time\": \"10:50:00\",\n                \"end_time\": \"12:50:00\",\n                \"booking_startime\": \"2018-07-19 11:25:00\",\n                \"booking_endtime\": \"2018-07-19 14:25:00\",\n                \"booking_status\": \"COMPLETED\",\n                \"address\": \"Test - Susmita\",\n                \"city\": \"Ahmedabad\",\n                \"state\": \"Gujarat\",\n                \"zip\": \"380001\",\n                \"babies\": [\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    },\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    },\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    },\n                    {\n                        \"baby_id\": 1,\n                        \"title\": \"New Name - updatd\",\n                        \"birthdate\": \"01/01/2014\",\n                        \"age\": 4,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                    },\n                    {\n                        \"baby_id\": 3,\n                        \"title\": \"Anuj New Name\",\n                        \"birthdate\": \"01/01/1992\",\n                        \"age\": 26,\n                        \"description\": \"This is test Baby.\",\n                        \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                    }\n                ],\n                \"payment\": {\n                    \"payment_id\": 3,\n                    \"per_hour\": 10,\n                    \"total_hour\": 3,\n                    \"sub_total\": 30,\n                    \"tax\": 0,\n                    \"other_charges\": 0,\n                    \"parking_fees\": 0,\n                    \"total\": 30,\n                    \"description\": \"Test Mode - Payment\",\n                    \"payment_status\": 0,\n                    \"payment_via\": \"\",\n                    \"payment_details\": \"\"\n                }\n            }\n        ]\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Booking!\"\n    },\n    \"status\": false,\n    \"message\": \"No Booking Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/my-earnings"
      }
    ]
  },
  {
    "type": "get",
    "url": "sitters/past-bookings",
    "title": "Past Bookings - Sitter App",
    "name": "sitters_past_bookings",
    "group": "Sitter",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n    {\n    \"data\": [\n        {\n            \"booking_id\": 1,\n            \"user_id\": 1,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-05-24\",\n            \"start_time\": \"10:23:17\",\n            \"end_time\": \"10:23:19\",\n            \"booking_startime\": \"2018-05-24 08:17:18\",\n            \"booking_endtime\": \"2018-05-24 08:22:22\",\n            \"booking_status\": \"COMPLETED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 3,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 0,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": null,\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                }\n            ]\n        },\n        {\n            \"booking_id\": 8,\n            \"user_id\": 3,\n            \"sitter_id\": 2,\n            \"user_name\": \"Anuj Jaha - 3\",\n            \"sitter_name\": \"Anuj Jaha - 2\",\n            \"sitter_contact\": \"\",\n            \"sitter_rating\": 0,\n            \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n            \"baby_id\": 1,\n            \"is_multiple\": 1,\n            \"booking_date\": \"2018-01-01\",\n            \"start_time\": \"10:50:00\",\n            \"end_time\": \"12:50:00\",\n            \"booking_startime\": \"2018-01-01 10:50:00\",\n            \"booking_endtime\": \"2018-01-01 12:50:00\",\n            \"booking_status\": \"REQUESTED\",\n            \"babies\": [\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 1,\n                    \"title\": \"New Name - updatd\",\n                    \"birthdate\": \"01/01/2014\",\n                    \"age\": 4,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/82052_baby.jpg\"\n                },\n                {\n                    \"baby_id\": 3,\n                    \"title\": \"Anuj New Name\",\n                    \"birthdate\": \"01/01/1992\",\n                    \"age\": 26,\n                    \"description\": \"This is test Baby.\",\n                    \"image\": \"http://nanny-app.local/uploads/babies/90492_baby.\"\n                }\n            ]\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Booking Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/past-bookings"
      }
    ]
  },
  {
    "type": "post",
    "url": "sitters/vacation",
    "title": "Vacation Mode - Sitter App",
    "name": "sitters_vacation",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Vacation": [
          {
            "group": "Vacation",
            "type": "integer",
            "optional": false,
            "field": "vacation_mode",
            "description": "<p>Vacation Mode ( 1/0 )  - Required</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n{\n        \"data\": {\n            \"success\": \"Vacation Mode Updated\"\n        },\n        \"status\": true,\n        \"message\": \"On Vacation - Enjoy Holidays!\",\n        \"code\": 200\n    }",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Plan Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Sitter!\"\n    },\n    \"status\": false,\n    \"message\": \"No Sitter Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/sitters/vacation"
      }
    ]
  },
  {
    "type": "post",
    "url": "update-sitter-profile",
    "title": "Update Profile - Sitter App",
    "name": "update_sitter_profile",
    "group": "Sitter",
    "parameter": {
      "fields": {
        "Update": [
          {
            "group": "Update",
            "type": "string",
            "optional": false,
            "field": "name",
            "description": "<p>Name - Optional</p>"
          },
          {
            "group": "Update",
            "type": "string",
            "optional": false,
            "field": "about_me",
            "description": "<p>About Me - Optional</p>"
          },
          {
            "group": "Update",
            "type": "integer",
            "optional": false,
            "field": "vacation_mode",
            "description": "<p>Vacation Mode ( 0 / 1) - Optional</p>"
          },
          {
            "group": "Update",
            "type": "string",
            "optional": false,
            "field": "description",
            "description": "<p>Description - Optional</p>"
          },
          {
            "group": "Update",
            "type": "string",
            "optional": false,
            "field": "category",
            "description": "<p>Category - Optional</p>"
          }
        ]
      }
    },
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "\n     {\n    \"data\": {\n        \"user_id\": 2,\n        \"user_token\": \"\",\n        \"email\": \"executive@executive.com\",\n        \"about_me\": true,\n        \"category\": \"Baby Child\",\n        \"vacation_mode\": 1,\n        \"description\": \"Thisi s descrition\",\n        \"user_type\": 0,\n        \"name\": \"Anuj Jaha - 2\",\n        \"mobile\": \"\",\n        \"device_token\": \"\",\n        \"device_type\": 0,\n        \"profile_pic\": \"http://nanny-app.local/uploads/user/default.png\",\n        \"address\": \"\",\n        \"city\": \"\",\n        \"state\": \"\",\n        \"zip\": \"\",\n        \"gender\": \"\",\n        \"birthdate\": \"\",\n        \"notification_count\": 0,\n        \"profile_completion\": 20,\n        \"status\": 1,\n        \"baby_count\": 0,\n        \"social_provider\": \"\",\n        \"social_token\": \"\"\n    },\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Sitter Found ):",
          "content": "{\n    \"error\": {\n        \"reason\": \"Invalid Inputs\"\n    },\n    \"status\": false,\n    \"message\": \"Something went wrong !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Sitter",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/update-sitter-profile"
      }
    ]
  },
  {
    "type": "get",
    "url": "plans",
    "title": "Subscription Plans ( Headers Required)",
    "name": "plans",
    "group": "Subscription_Plans",
    "success": {
      "examples": [
        {
          "title": "Success-Response:",
          "content": "{\n    \"data\": [\n        {\n            \"plan_id\": 1,\n            \"title\": \"1 Reservation\",\n            \"sub_title\": \"Single\",\n            \"amount\": 20,\n            \"description\": \"This is single plan\",\n            \"plan_type\": \"A\"\n        },\n        {\n            \"plan_id\": 2,\n            \"title\": \"10 Reservations\",\n            \"sub_title\": \"Multiple\",\n            \"amount\": 25,\n            \"description\": \"10 Reservations\",\n            \"plan_type\": \"B\"\n        },\n        {\n            \"plan_id\": 3,\n            \"title\": \"Unlimited Reservations\",\n            \"sub_title\": \"Unlimited\",\n            \"amount\": 59,\n            \"description\": \"Unlimited \",\n            \"plan_type\": \"C\"\n        }\n    ],\n    \"status\": true,\n    \"message\": \"Success\",\n    \"code\": 200\n}",
          "type": "json"
        }
      ]
    },
    "error": {
      "examples": [
        {
          "title": "Error-Response ( NO Plan Found ):",
          "content": "{\n    \"error\": {\n        \"message\": \"Unable to find Plans!\"\n    },\n    \"status\": false,\n    \"message\": \"No Plans Found !\",\n    \"code\": 400\n}",
          "type": "json"
        }
      ]
    },
    "version": "0.0.0",
    "filename": "nanny-input/example.js",
    "groupTitle": "Subscription_Plans",
    "sampleRequest": [
      {
        "url": "http://35.154.84.230/nanny/public/api/plans"
      }
    ]
  }
] });
