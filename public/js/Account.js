/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 4);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/Account.js":
/*!*********************************!*\
  !*** ./resources/js/Account.js ***!
  \*********************************/
/*! no static exports found */
/***/ (function(module, exports) {

var deleteIcon = function deleteIcon(cell, formatterParams, onRendered) {
  return '<button class="btn-red"><i class="fas fa-times"></i></button>';
};

var editIcon = function editIcon(cell, formatterParams, onRendered) {
  return '<i class="far fa-edit"></i>';
};

var passwordIcon = function passwordIcon(cell, formatterParams, onRendered) {
  return '<i class="fas fa-user-lock"></i>';
};

var table = new Tabulator("#account-table", {
  layout: "fitDataFill",
  data: data,
  headerFilterPlaceholder: "Search",
  responsiveLayout: "collapse",
  responsiveLayoutCollapseStartOpen: false,
  columns: [{
    formatter: "responsiveCollapse",
    width: 50,
    minWidth: 30,
    align: "center",
    headerSort: false,
    resizable: false,
    responsive: 0
  }, {
    title: "ID",
    field: "id",
    responsive: 0
  }, {
    title: "Username",
    field: "username",
    headerFilter: true,
    responsive: 0
  }, {
    title: "Full Name",
    field: "full_name",
    headerFilter: true,
    responsive: 1
  }, {
    title: "Role",
    field: "role",
    headerFilter: true,
    responsive: 1
  }, {
    title: "Gender",
    field: "gender",
    headerFilter: true,
    responsive: 1
  }, {
    title: "Contact No",
    field: "contact",
    headerFilter: true,
    responsive: 1
  }, {
    title: "Email",
    field: "email",
    headerFilter: true,
    responsive: 1
  }, {
    title: "Edit",
    formatter: editIcon,
    align: "center",
    tooltip: "Edit",
    responsive: 0,
    cellClick: function cellClick(e, cell) {
      var obj = {};
      Object.assign(obj, cell.getData());
      accountDetail.accountDetail = obj;
      accountDetail.isEdit = true;
      toggleOverlay('#account-detail-overlay');
    }
  }, {
    title: "Remove",
    formatter: deleteIcon,
    align: "center",
    tooltip: "Remove",
    responsive: 0,
    cellClick: function cellClick(e, cell) {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure on removing this account?',
        showCancelButton: true,
        cancelButtonColor: '#d9534f',
        cancelButtonText: "No",
        confirmButtonColor: '#5cb85c',
        confirmButtonText: 'Yes'
      }).then(function (result) {
        if (result.value) {
          jsonAjax("/Account/RemoveAccount", "POST", JSON.stringify({
            id: cell.getData().id
          }), function (response) {
            if (response.Status == "Success") {
              SwalSuccess('Account is succesfully removed.', '');
              table.setData(response.Data);
              return 0;
            }

            if (response.Status == "Database Error") {
              SwalError('Database Error. Please contact administrator.', '');
            }
          }, alertError);
        }
      });
    }
  }]
});
var accountDetail = new Vue({
  el: "#account-detail",
  data: {
    accountDetail: {
      id: "",
      username: "",
      password: "",
      confirmPassword: "",
      full_name: "",
      gender: "",
      contact: "",
      email: "",
      role: ""
    },
    error: {},
    isEdit: false
  },
  methods: {
    handleSubmit: function handleSubmit(event) {
      var formData = new FormData(event.target);

      if (this.isEdit) {
        formAjax("/Account/EditAccount", "POST", formData, this.editAccount, alertError);
      } else {
        if (this.checkPassword()) {
          formAjax("/Account/AddAccount", "POST", formData, this.addAccount, alertError);
        } else {
          SwalError('Invalid detail. Please check error messages.', '');
          this.error = {
            password: ["Password does not match."]
          };
        }
      }
    },
    hide: function hide() {
      this.accountDetail = {
        id: "",
        username: "",
        password: "",
        confirmPassword: "",
        full_name: "",
        gender: "",
        contact: "",
        email: "",
        role: ""
      };
      this.error = {};
      toggleOverlay('#account-detail-overlay');
    },
    addAccount: function addAccount(response) {
      if (response.Status == "Success") {
        SwalSuccess('New account is successfully added.', '');
        table.setData(response.Data);
        this.hide();
        return 0;
      }

      if (response.Status == "Validation Error") {
        SwalError('Invalid detail. Please check error messages.', '');
        this.error = response.Message;
        return 0;
      }

      if (response.Status == "Database Error") {
        SwalError('Database Error. Please contact administrator.', '');
      }
    },
    editAccount: function editAccount(response) {
      if (response.Status == "Success") {
        SwalSuccess('Account is successfully edited.', '');
        table.setData(response.Data);
        this.hide();
        return 0;
      }

      if (response.Status == "Validation Error") {
        SwalError('Invalid detail. Please check error messages.', '');
        this.error = response.Message;
        return 0;
      }

      if (response.Status == "Database Error") {
        SwalError('Database Error. Please contact administrator.', '');
      }
    },
    checkPassword: function checkPassword() {
      if (this.accountDetail.password == this.accountDetail.confirmPassword) {
        return true;
      } else {
        return false;
      }
    }
  }
});

/***/ }),

/***/ 4:
/*!***************************************!*\
  !*** multi ./resources/js/Account.js ***!
  \***************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\Frost\Desktop\Laravel\Computer-Website\resources\js\Account.js */"./resources/js/Account.js");


/***/ })

/******/ });