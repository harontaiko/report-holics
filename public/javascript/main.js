/**
 * @author [harontaiko]
 * @email [harontaiko@gmail.com]
 * @create date 2021-04-30 04:18:24
 * @modify date 2021-04-30 04:18:24
 * @desc [MARKUP BASED JAVASCRIPT, BASED ON PAUL IRISH'S DOM INTRUBUSIVE JS]
 */
/**MARKUP BASED JAVASCRIPT, BASED ON PAUL IRISH'S DOM INTRUBUSIVE JS */
var hostUrl = document.querySelector("link[rel='host']").getAttribute("href");

UTIL = {
  fire: function (func, funcname, args) {
    var namespace = dailyreport;

    funcname = funcname === undefined ? "init" : funcname;
    if (
      func !== "" &&
      namespace[func] &&
      typeof namespace[func][funcname] == "function"
    ) {
      namespace[func][funcname](args);
    }
  },

  loadEvents: function () {
    var bodyId = document.body.id;

    // hit up common first.
    UTIL.fire("common");

    // do all the classes too.
    $.each(document.body.className.split(/\s+/), function (i, classnm) {
      UTIL.fire(classnm);
      UTIL.fire(classnm, bodyId);
    });

    UTIL.fire("common", "finalize");
  },
};

function readURL(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
      $("#product-avatar").attr("src", e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
  }
}

function sleep(time) {
  return new Promise((resolve) => setTimeout(resolve, time));
}

function FilterInventory() {
  //JS table filter
  (function (document) {
    "use strict";

    var LightTableFilter = (function (Arr) {
      var _input;

      function _onInputEvent(e) {
        _input = e.target;
        var tables = document.getElementsByClassName(
          _input.getAttribute("data-table")
        );
        Arr.forEach.call(tables, function (table) {
          Arr.forEach.call(table.tBodies, function (tbody) {
            Arr.forEach.call(tbody.rows, _filter);
          });
        });
      }

      function _filter(row) {
        var text = row.textContent.toLowerCase(),
          val = _input.value.toLowerCase();
        row.style.display = text.indexOf(val) === -1 ? "none" : "table-row";
      }

      return {
        init: function () {
          var inputs = document.getElementsByClassName("light-table-filter");
          Arr.forEach.call(inputs, function (input) {
            input.oninput = _onInputEvent;
          });
        },
      };
    })(Array.prototype);

    document.addEventListener("readystatechange", function () {
      if (document.readyState === "complete") {
        LightTableFilter.init();
      }
    });
  })(document);
  //Filter Table
}

// kick it all off here
$(document).ready(UTIL.loadEvents);

//BEGIN EXECUTION HERE BASED ON PAGE
dailyreport = {
  __dailyreport: {
    init: function _homepage() {
      $("#latest-record").animate({ opacity: 0 }, 1000);
      $("#latest-record").animate({ opacity: 1 }, 1000);
      sleep(4700).then(() => {
        $("#latest-record").animate({ opacity: 0 }, 0);
        $("#latest-record").animate({ opacity: 1 }, 0);
      });
      FilterInventory();
      //main page js
      $("#toggler").click(function () {
        $("#vertical-navigation").toggleClass("v-nav-expand");
      });

      const navTabs = document.querySelectorAll("#nav-tabs > a");
      navTabs.forEach((tab) => {
        tab.addEventListener("click", () => {
          navTabs.forEach((tab) => {
            tab.classList.remove("active");
          });
          tab.classList.add("active");
        });
      });
    },
  },
  __login: {
    init: function _login() {
      //disable password pasting
      const pasteBox = document.getElementById("login-pwd");
      pasteBox.onpaste = (e) => {
        e.preventDefault();
        return false;
      };
      $(".message a").click(function () {
        $("form").animate({ height: "toggle", opacity: "toggle" }, "slow");
      });
    },
  },
  __add: {
    init: function _add() {
      document.getElementById("date").valueAsDate = new Date();

      FilterInventory();
      const cyberCash = document.getElementById("cyber-cash");
      const cyberTill = document.getElementById("cyber-till");
      const psCash = document.getElementById("ps-cash");
      const psTill = document.getElementById("ps-till");
      const movieCash = document.getElementById("movie-cash");
      const movieTill = document.getElementById("movie-till");
      const salesCash = document.getElementById("sales-cash");
      const salesTill = document.getElementById("sales-till");
      const boughtPrice = document.getElementById("bought-price");
      const salesProfit = document.getElementById("sales-profit");
      const expensesValue = document.getElementById("expense-value");

      //calculate pofit
      salesCash.addEventListener("input", function () {
        //check if till has a value and forbid
        if (salesTill.value !== "") {
          salesTill.style.border = "2px solid red";
          salesTill.style.outline = "none";
          //error
          document.getElementsByName("sales-till")[0].placeholder =
            "fill one only";
          sleep(1000).then(() => {
            document.getElementsByName("sales-till")[0].placeholder =
              "sell..till/other";
            salesTill.style.border = "";
            salesTill.style.outline = "";
            salesTill.value = "";
          });
        } else {
          if (salesCash.value == "") {
            salesProfit.value = 0;
          } else {
            salesProfit.value = salesCash.value - boughtPrice.value;
          }
        }
      });
      salesTill.addEventListener("input", function () {
        //check if till has a value and forbid
        if (salesCash.value !== "") {
          salesCash.style.border = "2px solid red";
          salesCash.style.outline = "none";
          //error
          document.getElementsByName("sales-cash")[0].placeholder =
            "fill one only";
          sleep(1000).then(() => {
            document.getElementsByName("sales-till")[0].placeholder =
              "sell..cash";
            salesCash.style.border = "";
            salesCash.style.outline = "";
            salesCash.value = "";
          });
        } else {
          if (salesTill.value == "") {
            salesProfit.value = 0;
          } else {
            salesProfit.value = salesTill.value - boughtPrice.value;
          }
        }
      });
      //get all values and sum in total input
      let incomeRecords = [
        cyberCash,
        cyberTill,
        psCash,
        psTill,
        movieCash,
        movieTill,
        salesProfit,
        expensesValue,
      ];

      //real time income total(ksh)
      $(document).on("input", ".income-calc", function () {
        var sum = 0;
        $(".income-calc").each(function () {
          sum += +$(this).val();
        });
        $("#total-cash").val(sum);
        var totalCash = $("#total-cash").val(sum);
        document.getElementById(
          "total-sales-out-cash"
        ).innerHTML = `cash total: ${sum}`;
      });

      //real time income total(till)
      $(document).on("input", ".income-calc-till", function () {
        var sum = 0;
        $(".income-calc-till").each(function () {
          sum += +$(this).val();
        });
        $("#total-till").val(sum);
        var totalTill = $("#total-till").val(sum);
        document.getElementById(
          "total-sales-out-till"
        ).innerHTML = `till total: ${sum}`;
      });

      //get buying price of selected item in sales
      var salesOptions = document.getElementById("product");

      salesOptions.addEventListener("change", function LoadBuying() {
        currentOption = salesOptions.value;
        currentOptionText = this.options[this.selectedIndex].text;

        $("#sc").load(
          `loadBuying/${currentOption}`,
          function (res, status, http) {
            document.getElementById("bought-price").value = res;
            document.getElementById("bought-item").value = currentOptionText;
          }
        );
      });

      //auto load first items details onto text

      //add sale
      $(document).ready(function () {
        //load expense onto DOM
        $("#exp").load(
          `loadLatestExpense/${document.getElementById("date").value}`
        );
        //load sold i==onto DOM
        $("#sl").load(
          `loadLatestSold/${document.getElementById("date").value}`
        );

        //load date
        document.getElementById(`date__`).value =
          document.getElementById("date").value;
        //arrange selling items alphabetically
        $("#product").append(
          $("#product option")
            .remove()
            .sort(function (a, b) {
              var at = $(a).text(),
                bt = $(b).text();
              return at > bt ? 1 : at < bt ? -1 : 0;
            })
        );
        //on date change
        document.getElementById("date").addEventListener("change", () => {
          //load expense onto DOM
          $("#exp").load(
            `loadLatestExpense/${document.getElementById("date").value}`
          );
          //load sold i==onto DOM
          $("#sl").load(
            `loadLatestSold/${document.getElementById("date").value}`
          );
        });

        //on page load, since page loads with default date
        document.addEventListener("load", (event) => {
          //load expense onto DOM
          $("#exp").load(
            `loadLatestExpense/${document.getElementById("date").value}`
          );
          //load sold i==onto DOM
          $("#sl").load(
            `loadLatestSold/${document.getElementById("date").value}`
          );
        });

        //create record of all sale
        $(".save-record").click(function (e) {
          e.preventDefault();
          //validate relevant inputs
          if (
            cyberCash.value == "" ||
            cyberTill.value == "" ||
            movieCash.value == "" ||
            movieTill.value == "" ||
            psCash.value == "" ||
            psTill.value == "" ||
            document.getElementById("date").value == ""
          ) {
            cyberTill.style.border = "1.5px solid red";
            cyberCash.style.border = "1.5px solid red";
            movieTill.style.border = "1.5px solid red";
            movieCash.style.border = "1.5px solid red";
            psCash.style.border = "1.5px solid red";
            psTill.style.border = "1.5px solid red";
            sleep(2500).then(() => {
              cyberTill.style.border = "";
              cyberCash.style.border = "";
              movieTill.style.border = "";
              movieCash.style.border = "";
              psCash.style.border = "";
              psTill.style.border = "";
            });
          } else {
            //check for atleast one sale & expense
            //if none, proceed but with warning
            $.ajax({
              url: `${hostUrl}/pages/CheckSaleExpense`,
              type: "GET",
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //status==okay, proceed
                  result1 = confirm(
                    "do you confirm that the sale data is correct, click ok to seed and save record"
                  );
                  if (!result1) {
                  } else {
                    //save to db
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecord`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                        date: document.getElementById("date").value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //save net total
                          $.ajax({
                            url: `${hostUrl}/pages/SaveNetTotal`,
                            type: "POST",
                            data: {
                              date: document.getElementById("date").value,
                            },
                            dataType: "json",
                            success: function (dataResult) {
                              if (dataResult.statusCode == 200) {
                                //success, redirect to home page
                                location.replace(
                                  `${hostUrl}/pages/dailyreport`
                                );
                              } else if (dataResult.statusCode == 317) {
                                document.querySelector(".alert").style.display =
                                  "block";
                                document.getElementById(
                                  "add-alert"
                                ).style.color = "#fff";
                                $("#add-alert").html(
                                  "an error occurred, record could not be saved, please check your connection"
                                );

                                sleep(4700).then(() => {
                                  document.querySelector(
                                    ".alert_success"
                                  ).style.display = "none";
                                  document.getElementById(
                                    "add-alert"
                                  ).innerHTML = "";
                                });
                              }
                            },
                          });
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                  }
                } else if (dataResult.statusCode == 317) {
                  //status=not ok, proceed with warning, no sale
                  result2 = confirm(
                    "No sale made, do you still want to continue?"
                  );
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecord`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                        date: document.getElementById("date").value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //save net total
                          $.ajax({
                            url: `${hostUrl}/pages/SaveNetTotal`,
                            type: "POST",
                            data: {
                              date: document.getElementById("date").value,
                            },
                            dataType: "json",
                            success: function (dataResult) {
                              if (dataResult.statusCode == 200) {
                                //success, redirect to home page
                                location.replace(
                                  `${hostUrl}/pages/dailyreport`
                                );
                              } else if (dataResult.statusCode == 317) {
                                document.querySelector(".alert").style.display =
                                  "block";
                                document.getElementById(
                                  "add-alert"
                                ).style.color = "#fff";
                                $("#add-alert").html(
                                  "an error occurred, record could not be saved, please check your connection"
                                );

                                sleep(4700).then(() => {
                                  document.querySelector(
                                    ".alert_success"
                                  ).style.display = "none";
                                  document.getElementById(
                                    "add-alert"
                                  ).innerHTML = "";
                                });
                              }
                            },
                          });
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                  }
                } else if (dataResult.statusCode == 318) {
                  //status=not ok, proceed with warning, no expense
                  result2 = confirm(
                    "No expenses added, please add null expense?"
                  );
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecord`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                        date: document.getElementById("date").value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //save net total
                          $.ajax({
                            url: `${hostUrl}/pages/SaveNetTotal`,
                            type: "POST",
                            data: {
                              date: document.getElementById("date").value,
                            },
                            dataType: "json",
                            success: function (dataResult) {
                              if (dataResult.statusCode == 200) {
                                //success, redirect to home page
                                location.replace(
                                  `${hostUrl}/pages/dailyreport`
                                );
                              } else if (dataResult.statusCode == 317) {
                                document.querySelector(".alert").style.display =
                                  "block";
                                document.getElementById(
                                  "add-alert"
                                ).style.color = "#fff";
                                $("#add-alert").html(
                                  "an error occurred, record could not be saved, please check your connection"
                                );

                                sleep(4700).then(() => {
                                  document.querySelector(
                                    ".alert_success"
                                  ).style.display = "none";
                                  document.getElementById(
                                    "add-alert"
                                  ).innerHTML = "";
                                });
                              }
                            },
                          });
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                  }
                } else if (dataResult.statusCode == 319) {
                  //status=not ok, proceed with warning, no expense and sale
                  result2 = confirm(
                    "No sale or expense today, do you still want to continue?"
                  );
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecord`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                        date: document.getElementById("date").value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //save net total
                          $.ajax({
                            url: `${hostUrl}/pages/SaveNetTotal`,
                            type: "POST",
                            data: {
                              date: document.getElementById("date__").value,
                            },
                            dataType: "json",
                            success: function (dataResult) {
                              if (dataResult.statusCode == 200) {
                                //success, redirect to home page
                                location.replace(
                                  `${hostUrl}/pages/dailyreport`
                                );
                              } else if (dataResult.statusCode == 317) {
                                document.querySelector(".alert").style.display =
                                  "block";
                                document.getElementById(
                                  "add-alert"
                                ).style.color = "#fff";
                                $("#add-alert").html(
                                  "an error occurred, record could not be saved, please check your connection"
                                );

                                sleep(4700).then(() => {
                                  document.querySelector(
                                    ".alert_success"
                                  ).style.display = "none";
                                  document.getElementById(
                                    "add-alert"
                                  ).innerHTML = "";
                                });
                              }
                            },
                          });
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                  }
                }
              },
            });
          }
        });

        //add expense
        $("#n-expense").click(function (e) {
          //validate expense input
          if (
            document.getElementById("expense_n").value == "" ||
            document.getElementById("expense-value").value == ""
          ) {
            document.getElementById("expense_n").style.border =
              "1.5px solid red";
            document.getElementById("expense-value").style.border =
              "1.5px solid red";
            sleep(2250).then(() => {
              document.getElementById("expense_n").style.border = "";
              document.getElementById("expense-value").style.border = "";
            });
          } else {
            //submit expense
            var expense_name = document.getElementById("expense_n").value;
            var expense_val = document.getElementById("expense-value").value;
            $.ajax({
              url: `${hostUrl}/pages/SaveExpense`,
              type: "POST",
              data: {
                expense: expense_name,
                amount: expense_val,
                date: document.getElementById("date__").value,
              },
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //clear inputs
                  [
                    document.getElementById("expense_n"),
                    document.getElementById("expense-value"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  //load expense onto DOM
                  $("#exp").load(
                    `loadLatestExpense/${document.getElementById("date").value}`
                  );
                } else if (dataResult.statusCode == 317) {
                  //error,
                }
              },
            });
          }
        });

        $("form").on("submit", function (e) {
          e.preventDefault();

          var form = $(this);

          //validate
          if (salesProfit.value == "") {
            document.getElementById("sales-cash").style.border =
              "1.5px solid red";
            document.getElementById("bought-item").style.border =
              "1.5px solid red";
            document.getElementById("bought-price").style.border =
              "1.5px solid red";
            document.getElementById("sales-till").style.border =
              "1.5px solid red";
            sleep(2500).then(() => {
              document.getElementById("bought-item").style.border = "";
              document.getElementById("bought-price").style.border = "";
              document.getElementById("sales-cash").style.border = "";
              document.getElementById("sales-till").style.border = "";
            });
          } else {
            //add to db, item == itemId
            var boughtsales = document.getElementById("bought-price").value;
            var boughtItems = document.getElementById("bought-item").value;
            var cashsales = document.getElementById("sales-cash").value;
            var tillsales = document.getElementById("sales-till").value;
            var profitsales = document.getElementById("sales-profit").value;
            var itemsales = document.getElementById("product").value;

            //save cash sales
            $.ajax({
              url: `${hostUrl}/pages/saveSaleCash`,
              type: "POST",
              data: form.serialize(),
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //success
                  //clear all inputs
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  $("#product").prop("selected", function () {
                    return this.defaultSelected;
                  });
                  //load sold i==onto DOM
                  $("#sl").load(
                    `loadLatestSold/${document.getElementById("date").value}`
                  );
                  //update inventory real time
                  $("#open-modal").load(`loadInventoryData`);
                } else if (dataResult.statusCode == 317) {
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("add-alert").style.color = "#f85f5f";
                  $("#add-alert").html(
                    "connection error, check database or internet connection"
                  );

                  sleep(4700).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("add-alert").innerHTML = "";
                  });
                } else if (dataResult.statusCode == 318) {
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("add-alert").style.color = "#fff";
                  $("#add-alert").html(
                    "the item is currently not in stock, add it to the inventory first!"
                  );

                  sleep(4700).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("add-alert").innerHTML = "";
                  });
                }
              },
            });
          }
        });
      });
    },
  },
  __verify: {
    init: function _verify() {
      document
        .getElementById("passwordnew")
        .addEventListener("input", validatepassword);
      function validatepassword() {
        const pwd = document.getElementById("passwordnew");
        const output_pwd_err = document.querySelector("#passwordnew-err");
        const reg_valid_pwd =
          /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/; //1 num, 1 ucase char, 1 Lcase char and atleast 8 chars
        //create an illusion when the only thing being done, is checking char length
        if (pwd.value.length < 8) {
          pwd.style.border = "2px solid red";
          pwd.style.outline = "none";

          output_pwd_err.style.display = "block";
          output_pwd_err.innerHTML =
            "password must contain at least 8 characters   1 lowercase character 1 upercase character and  1 numeric value";
          sleep(7500).then(() => {
            output_pwd_err.style.display = "none";
          });
        } else {
          output_pwd_err.style.display = "none";
          pwd.style.border = "";
        }
      }

      document
        .getElementById("passwordnew-c")
        .addEventListener("input", validatepassword2);
      function validatepassword2() {
        const pwd_ = document.getElementById("passwordnew-c");
        const pwd2 = document.getElementById("passwordnew");
        const output_pwd_err2 = document.querySelector("#passwordnew-err-c");
        //create an illusion when the only thing being done, is checking char length
        if (pwd_.value !== pwd2.value) {
          pwd_.style.border = "2px solid red";
          pwd_.style.outline = "none";

          output_pwd_err2.style.display = "block";
          output_pwd_err2.innerHTML = "password do not match";
          sleep(7500).then(() => {
            output_pwd_err2.style.display = "none";
          });
        } else {
          output_pwd_err2.style.display = "none";
          pwd_.style.border = "";
        }
      }
    },
  },
  __playstation: {
    init: function _ps() {
      FilterInventory();
      var psoptions = document.getElementById("filter-playstation");

      psoptions.addEventListener("change", function LoadBuying() {
        currentOption = psoptions.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(`${hostUrl}/pages/reports/ps/${currentOptionText}`);
      });

      //get ps report between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/ps/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __cyber: {
    init: function _ps() {
      FilterInventory();
      var cyberoptions = document.getElementById("filter-cyber");

      cyberoptions.addEventListener("change", function LoadBuying() {
        currentOption = cyberoptions.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(`${hostUrl}/pages/reports/cyber/${currentOptionText}`);
      });

      //get cyber report between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/cyber/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __addItem: {
    init: function _ps() {
      FilterInventory();
      //save item to inventory
      $(document).ready(function () {
        $("form").on("submit", function (e) {
          e.preventDefault();
          //get values including file if exists
          var itemName = document.querySelector("#item-name");
          var itemQt = document.querySelector("#item-quantity");
          var itemBp = document.querySelector("#item-bp");
          var itemModel = document.querySelector("#model");
          itemImage = document.querySelector("#product-image");

          //disable btn after success to avoid further clicks
          document.querySelector("#add-record-invent").disabled = true;

          //product image
          var fd = new FormData();
          var files = $("#product-image")[0].files[0];
          fd.append("product-image", files);
          //save inventory item
          $.ajax({
            url: `${hostUrl}/pages/saveInventory`,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (dataResult) {
              if (dataResult.statusCode == 200) {
                //remove alerts
                document.querySelector(".alert_success").style.display = "none";
                document.getElementsByClassName("loader")[0].style.display =
                  "block";

                sleep(2100).then(() => {
                  document.getElementsByClassName("loader")[0].style.display =
                    "none";
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("inventory-alert").style.display =
                    "block";
                  document.getElementById("inventory-alert").style.color =
                    "#fff";
                  document.getElementById("inventory-alert").innerHTML =
                    "item added successfully!";

                  //load new data to inventory UI
                  $("#open-modal").load(`loadInventoryData`);

                  //clear all inputs
                  [itemName, itemQt, itemBp, itemModel, itemImage].forEach(
                    (item) => {
                      item.value = "";
                    }
                  );

                  $("#product-avatar").attr(
                    "src",
                    `${hostUrl}/public/images/images/open-box.png`
                  );
                  document.getElementById("product-image").value = "";

                  sleep(3500).then(() => {
                    document.querySelector(
                      "#add-record-invent"
                    ).disabled = false;
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("inventory-alert").innerHTML = "";
                  });
                });
              } else if (dataResult.statusCode == 201) {
                document.querySelector(".alert").style.display = "block";
                document.getElementById("inventory-alert").style.color =
                  "#f44336";
                $("#inventory-alert").html(
                  "invalid file or missing field, please try again"
                );

                sleep(4700).then(() => {
                  document.querySelector(".alert_success").style.display =
                    "none";
                  document.getElementById("inventory-alert").innerHTML = "";
                });
              } else if (dataResult.statusCode == 417) {
                document.querySelector(".alert").style.display = "block";
                document.getElementById("inventory-alert").style.color =
                  "#f44336";
                $("#inventory-alert").html(
                  "request could not be completed, check your connection"
                );

                sleep(4700).then(() => {
                  document.querySelector(".alert_success").style.display =
                    "none";
                  document.getElementById("inventory-alert").innerHTML = "";
                });
              } else if (dataResult.statusCode == 317) {
                document.querySelector(".alert").style.display = "block";
                document.getElementById("inventory-alert").style.color =
                  "#f44336";
                $("#inventory-alert").html(
                  "please change the item name or image name, a similar record already exists"
                );

                sleep(4700).then(() => {
                  document.querySelector(".alert_success").style.display =
                    "none";
                  document.getElementById("inventory-alert").innerHTML = "";
                });
              }
            },
          });
        });
      });
    },
  },
  __expense: {
    init: function _ps() {
      FilterInventory();
      //filter in select
      var totalexpense = document.getElementById("filter-expense");

      totalexpense.addEventListener("change", function LoadBuying() {
        currentOption = totalexpense.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(
          `${hostUrl}/pages/reports/expense/${currentOptionText}`
        );
      });

      //get movieshop report between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/expense/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __filterReport: {
    init: function _ps() {
      FilterInventory();
    },
  },
  __movieshop: {
    init: function _ps() {
      FilterInventory();
      //filter in select
      var movieshopOptions = document.getElementById("fiter-movieshop");

      movieshopOptions.addEventListener("change", function LoadBuying() {
        currentOption = movieshopOptions.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(`${hostUrl}/pages/reports/movie/${currentOptionText}`);
      });

      //get movieshop report between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/movie/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __sales: {
    init: function _ps() {
      FilterInventory();
      //filter in select
      var totalsales = document.getElementById("filter-sales");

      totalsales.addEventListener("change", function LoadBuying() {
        currentOption = totalsales.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(`${hostUrl}/pages/reports/sales/${currentOptionText}`);
      });

      //get movieshop r between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/sales/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __total: {
    init: function _ps() {
      FilterInventory();
      //filter in select
      var totaloptions = document.getElementById("filter-total");

      totaloptions.addEventListener("change", function LoadBuying() {
        currentOption = totaloptions.value;
        currentOptionText = this.options[this.selectedIndex].value;
        //today, month & default
        location.replace(`${hostUrl}/pages/reports/total/${currentOptionText}`);
      });

      //get movieshop report between dates
      document.getElementById("get-repo-btw").addEventListener("click", () => {
        //validate dates
        var date1 = document.querySelector("#date-1");
        var date2 = document.querySelector("#date-2");
        if (date1.value !== "" && date2.value !== "") {
          //submit
          location.replace(
            `${hostUrl}/pages/date/total/${date1.value}/${date2.value}`
          );
        } else {
          date1.style.border = "2px solid red";
          date1.style.outline = "none";
          date2.style.border = "2px solid red";
          date2.style.outline = "none";
          sleep(2500).then(() => {
            date1.style.border = "";
            date1.style.outline = "";
            date2.style.border = "";
            date2.style.outline = "";
          });
        }
      });
    },
  },
  __reports: {
    init: function _repo() {
      FilterInventory();
    },
  },
  __viewEdit: {
    init: function __viewEdit() {
      FilterInventory();
      const cyberCash = document.getElementById("cyber-cash");
      const cyberTill = document.getElementById("cyber-till");
      const psCash = document.getElementById("ps-cash");
      const psTill = document.getElementById("ps-till");
      const movieCash = document.getElementById("movie-cash");
      const movieTill = document.getElementById("movie-till");
      const salesCash = document.getElementById("sales-cash");
      const salesTill = document.getElementById("sales-till");
      const boughtPrice = document.getElementById("bought-price");
      const salesProfit = document.getElementById("sales-profit");
      const expensesValue = document.getElementById("expense-value");

      //calculate pofit
      salesCash.addEventListener("input", function () {
        //check if till has a value and forbid
        if (salesTill.value !== "") {
          salesTill.style.border = "2px solid red";
          salesTill.style.outline = "none";
          //error
          document.getElementsByName("sales-till")[0].placeholder =
            "fill one only";
          sleep(1000).then(() => {
            document.getElementsByName("sales-till")[0].placeholder =
              "sell..till/other";
            salesTill.style.border = "";
            salesTill.style.outline = "";
            salesTill.value = "";
          });
        } else {
          if (salesCash.value == "") {
            salesProfit.value = 0;
          } else {
            salesProfit.value = salesCash.value - boughtPrice.value;
          }
        }
      });
      salesTill.addEventListener("input", function () {
        //check if till has a value and forbid
        if (salesCash.value !== "") {
          salesCash.style.border = "2px solid red";
          salesCash.style.outline = "none";
          //error
          document.getElementsByName("sales-cash")[0].placeholder =
            "fill one only";
          sleep(1000).then(() => {
            document.getElementsByName("sales-till")[0].placeholder =
              "sell..cash";
            salesCash.style.border = "";
            salesCash.style.outline = "";
            salesCash.value = "";
          });
        } else {
          if (salesTill.value == "") {
            salesProfit.value = 0;
          } else {
            salesProfit.value = salesTill.value - boughtPrice.value;
          }
        }
      });
      //get all values and sum in total input
      let incomeRecords = [
        cyberCash,
        cyberTill,
        psCash,
        psTill,
        movieCash,
        movieTill,
        salesProfit,
        expensesValue,
      ];

      //real time income total(ksh)
      $(document).on("input", ".income-calc", function () {
        var sum = 0;
        $(".income-calc").each(function () {
          sum += +$(this).val();
        });
        $("#total-cash").val(sum);
        var totalCash = $("#total-cash").val(sum);
        document.getElementById(
          "total-sales-out-cash"
        ).innerHTML = `cash total: ${sum}`;
      });

      //real time income total(till)
      $(document).on("input", ".income-calc-till", function () {
        var sum = 0;
        $(".income-calc-till").each(function () {
          sum += +$(this).val();
        });
        $("#total-till").val(sum);
        var totalTill = $("#total-till").val(sum);
        document.getElementById(
          "total-sales-out-till"
        ).innerHTML = `till total: ${sum}`;
      });

      //get buying price of selected item in sales
      var salesOptions = document.getElementById("product");

      salesOptions.addEventListener("change", function LoadBuying() {
        currentOption = salesOptions.value;
        currentOptionText = this.options[this.selectedIndex].text;
        var Recorddate = document.getElementById("recorddate").value;
        //LOAD BUYING PRICE
        $.ajax({
          url: `${hostUrl}/pages/loadBuyingEdit/${Recorddate}/${currentOption}`,
          type: "GET",
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              var bp = dataResult.row;
              document.getElementById("bought-price").value = bp;
              document.getElementById("bought-item").value = currentOptionText;
            } else {
              document.querySelector(".alert").style.display = "block";
              document.getElementById("add-alert").style.color = "#fff";
              $("#add-alert").html(
                "an error occurred, record could not be fetched, please check your connection"
              );

              sleep(4700).then(() => {
                document.querySelector(".alert_success").style.display = "none";
                document.getElementById("add-alert").innerHTML = "";
              });
            }
          },
        });
      });

      $(document).ready(function () {
        var Recorddate = document.getElementById("recorddate").value;
        //load expenses,sold items
        $.ajax({
          url: `${hostUrl}/pages/loadLatestExpenseEdit/${Recorddate}`,
          type: "GET",
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              var string = "";
              dataResult.row.forEach((exp) => {
                string += `<p id="${exp.expense_id}" class="total-expense">${exp.expense_item} - ${exp.expense_cost}
                <button class="close-expense" type="button">&times;</button>
                </p>`;
                $("#exp").html(string);
              });

              cancelExpense = document.querySelectorAll(".close-expense");

              for (var i = 0; i < cancelExpense.length; i++) {
                cancelExpense[i].addEventListener("click", function (event) {
                  if (!confirm("delete expense?")) {
                    event.preventDefault();
                  } else {
                    //del from db
                    currentId = this.parentNode.id;
                    hideParent = this.parentElement.style.display = "none";
                    $.ajax({
                      url: `${hostUrl}/pages/DeleteExpenseNow`,
                      type: "POST",
                      data: {
                        id: currentId,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //success, del element from DOM
                          hideParent;
                        } else if (dataResult.statusCode == 317) {
                          //for some reason, the id is not present once user accepts condition so,
                          //fx is true all the time
                          hideParent;
                        }
                      },
                    });
                  }
                });
              }
            } else {
              document.querySelector(".alert").style.display = "block";
              document.getElementById("add-alert").style.color = "#fff";
              $("#add-alert").html(
                "an error occurred, record could not be fetched, please check your connection"
              );

              sleep(4700).then(() => {
                document.querySelector(".alert_success").style.display = "none";
                document.getElementById("add-alert").innerHTML = "";
              });
            }
          },
        });

        //load sold items
        $.ajax({
          url: `${hostUrl}/pages/loadLatestSaleEdit/${Recorddate}`,
          type: "GET",
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              var string = "";
              dataResult.row.forEach((exp) => {
                string += `<p id="${exp.sales_id}" class="total-expense">${exp.sales_item} - ${exp.buying_price}
                <button class="close-sale" type="button">&times;</button>
                </p>`;
                $("#sl").html(string);
              });

              cancelExpense = document.querySelectorAll(".close-sale");

              for (var i = 0; i < cancelExpense.length; i++) {
                cancelExpense[i].addEventListener("click", function (event) {
                  if (!confirm("delete sale?")) {
                    event.preventDefault();
                  } else {
                    //del from db
                    currentId = this.parentNode.id;
                    hideParent = this.parentElement.style.display = "none";
                    $.ajax({
                      url: `${hostUrl}/pages/DeleteSaleNow`,
                      type: "POST",
                      data: {
                        id: currentId,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //success, del element from DOM
                          hideParent;
                        } else if (dataResult.statusCode == 317) {
                          //for some reason, the id is not present once user accepts condition so,
                          //fx is true all the time
                          hideParent;
                        }
                      },
                    });
                  }
                });
              }
            } else {
              document.querySelector(".alert").style.display = "block";
              document.getElementById("add-alert").style.color = "#fff";
              $("#add-alert").html(
                "an error occurred, record could not be fetched, please check your connection"
              );

              sleep(4700).then(() => {
                document.querySelector(".alert_success").style.display = "none";
                document.getElementById("add-alert").innerHTML = "";
              });
            }
          },
        });

        $("form").on("submit", function (e) {
          e.preventDefault();

          var form = $(this);

          //validate
          if (salesProfit.value == "") {
            document.getElementById("sales-cash").style.border =
              "1.5px solid red";
            document.getElementById("bought-item").style.border =
              "1.5px solid red";
            document.getElementById("bought-price").style.border =
              "1.5px solid red";
            document.getElementById("sales-till").style.border =
              "1.5px solid red";
            sleep(2500).then(() => {
              document.getElementById("bought-item").style.border = "";
              document.getElementById("bought-price").style.border = "";
              document.getElementById("sales-cash").style.border = "";
              document.getElementById("sales-till").style.border = "";
            });
          } else {
            //add to db, item == itemId
            var boughtsales = document.getElementById("bought-price").value;
            var boughtItems = document.getElementById("bought-item").value;
            var cashsales = document.getElementById("sales-cash").value;
            var tillsales = document.getElementById("sales-till").value;
            var profitsales = document.getElementById("sales-profit").value;
            var itemsales = document.getElementById("product").value;

            //save cash sales
            $.ajax({
              url: `${hostUrl}/pages/saveSaleCashEdit/${Recorddate}`,
              type: "POST",
              data: form.serialize(),
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //success
                  //clear all inputs
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  $("#product").prop("selected", function () {
                    return this.defaultSelected;
                  });
                  //load sold items
                  $.ajax({
                    url: `${hostUrl}/pages/loadLatestSaleEdit/${Recorddate}`,
                    type: "GET",
                    dataType: "json",
                    success: function (dataResult) {
                      if (dataResult.statusCode == 200) {
                        var string = "";
                        dataResult.row.forEach((exp) => {
                          string += `<p id="${exp.sales_id}" class="total-expense">${exp.sales_item} - ${exp.buying_price}
                <button class="close-sale" type="button">&times;</button>
                </p>`;
                          $("#sl").html(string);
                        });

                        cancelExpense =
                          document.querySelectorAll(".close-sale");

                        for (var i = 0; i < cancelExpense.length; i++) {
                          cancelExpense[i].addEventListener(
                            "click",
                            function (event) {
                              if (!confirm("delete sale?")) {
                                event.preventDefault();
                              } else {
                                //del from db
                                currentId = this.parentNode.id;
                                hideParent = this.parentElement.style.display =
                                  "none";
                                $.ajax({
                                  url: `${hostUrl}/pages/DeleteSaleNow`,
                                  type: "POST",
                                  data: {
                                    id: currentId,
                                  },
                                  dataType: "json",
                                  success: function (dataResult) {
                                    if (dataResult.statusCode == 200) {
                                      //success, del element from DOM
                                      hideParent;
                                    } else if (dataResult.statusCode == 317) {
                                      //for some reason, the id is not present once user accepts condition so,
                                      //fx is true all the time
                                      hideParent;
                                    }
                                  },
                                });
                              }
                            }
                          );
                        }
                      } else {
                        document.querySelector(".alert").style.display =
                          "block";
                        document.getElementById("add-alert").style.color =
                          "#fff";
                        $("#add-alert").html(
                          "an error occurred, record could not be fetched, please check your connection"
                        );

                        sleep(4700).then(() => {
                          document.querySelector(
                            ".alert_success"
                          ).style.display = "none";
                          document.getElementById("add-alert").innerHTML = "";
                        });
                      }
                    },
                  });
                  //update inventory real time
                } else if (dataResult.statusCode == 317) {
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("add-alert").style.color = "#f85f5f";
                  $("#add-alert").html(
                    "connection error, check database or internet connection"
                  );

                  sleep(4700).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("add-alert").innerHTML = "";
                  });
                } else if (dataResult.statusCode == 318) {
                  [
                    document.getElementById("bought-price"),
                    document.getElementById("bought-item"),
                    document.getElementById("sales-cash"),
                    document.getElementById("sales-till"),
                    document.getElementById("sales-profit"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("add-alert").style.color = "#fff";
                  $("#add-alert").html(
                    "the item is currently not in stock, add it to the inventory first!"
                  );

                  sleep(4700).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("add-alert").innerHTML = "";
                  });
                }
              },
            });
          }
        });

        //add expense
        $("#n-expense").click(function (e) {
          //validate expense input
          if (
            document.getElementById("expense_n").value == "" ||
            document.getElementById("expense-value").value == ""
          ) {
            document.getElementById("expense_n").style.border =
              "1.5px solid red";
            document.getElementById("expense-value").style.border =
              "1.5px solid red";
            sleep(2250).then(() => {
              document.getElementById("expense_n").style.border = "";
              document.getElementById("expense-value").style.border = "";
            });
          } else {
            //submit expense
            var expense_name = document.getElementById("expense_n").value;
            var expense_val = document.getElementById("expense-value").value;
            $.ajax({
              url: `${hostUrl}/pages/SaveExpenseEdit/${Recorddate}`,
              type: "POST",
              data: {
                expense: expense_name,
                amount: expense_val,
              },
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //clear inputs
                  [
                    document.getElementById("expense_n"),
                    document.getElementById("expense-value"),
                  ].forEach((item) => {
                    item.value = "";
                  });
                  //load expense onto DOM
                  $.ajax({
                    url: `${hostUrl}/pages/loadLatestExpenseEdit/${Recorddate}`,
                    type: "GET",
                    dataType: "json",
                    success: function (dataResult) {
                      if (dataResult.statusCode == 200) {
                        var string = "";
                        dataResult.row.forEach((exp) => {
                          string += `<p id="${exp.expense_id}" class="total-expense">${exp.expense_item} - ${exp.expense_cost}
                                  <button class="close-expense" type="button">&times;</button>
                                  </p>`;
                          $("#exp").html(string);
                        });

                        cancelExpense =
                          document.querySelectorAll(".close-expense");

                        for (var i = 0; i < cancelExpense.length; i++) {
                          cancelExpense[i].addEventListener(
                            "click",
                            function (event) {
                              if (!confirm("delete expense?")) {
                                event.preventDefault();
                              } else {
                                //del from db
                                currentId = this.parentNode.id;
                                hideParent = this.parentElement.style.display =
                                  "none";
                                $.ajax({
                                  url: `${hostUrl}/pages/DeleteExpenseNow`,
                                  type: "POST",
                                  data: {
                                    id: currentId,
                                  },
                                  dataType: "json",
                                  success: function (dataResult) {
                                    if (dataResult.statusCode == 200) {
                                      //success, del element from DOM
                                      hideParent;
                                    } else if (dataResult.statusCode == 317) {
                                      //for some reason, the id is not present once user accepts condition so,
                                      //fx is true all the time
                                      hideParent;
                                    }
                                  },
                                });
                              }
                            }
                          );
                        }
                      } else {
                        document.querySelector(".alert").style.display =
                          "block";
                        document.getElementById("add-alert").style.color =
                          "#fff";
                        $("#add-alert").html(
                          "an error occurred, record could not be fetched, please check your connection"
                        );

                        sleep(4700).then(() => {
                          document.querySelector(
                            ".alert_success"
                          ).style.display = "none";
                          document.getElementById("add-alert").innerHTML = "";
                        });
                      }
                    },
                  });
                } else if (dataResult.statusCode == 317) {
                  //error,
                  $("#add-alert").html(
                    "an error occurred while saving the expense, please check your connection"
                  );

                  sleep(4700).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("add-alert").innerHTML = "";
                  });
                }
              },
            });
          }
        });
        salesCash.style.border = "";
        salesTill.style.border = "";
        boughtPrice.style.border = "";
        salesProfit.style.border = "";
        //save all edited sale
        //create record of all sale
        $(".save-record").click(function (e) {
          e.preventDefault();
          //validate relevant inputs
          if (
            cyberCash.value == "" ||
            cyberTill.value == "" ||
            movieCash.value == "" ||
            movieTill.value == "" ||
            psCash.value == "" ||
            psTill.value == ""
          ) {
            cyberTill.style.border = "1.5px solid red";
            cyberCash.style.border = "1.5px solid red";
            movieTill.style.border = "1.5px solid red";
            movieCash.style.border = "1.5px solid red";
            psCash.style.border = "1.5px solid red";
            psTill.style.border = "1.5px solid red";
            sleep(2500).then(() => {
              cyberTill.style.border = "";
              cyberCash.style.border = "";
              movieTill.style.border = "";
              movieCash.style.border = "";
              psCash.style.border = "";
              psTill.style.border = "";
            });
          } else {
            //check for atleast one sale & expense
            //if none, proceed but with warning
            var Recorddate = document.getElementById("recorddate").value;

            $.ajax({
              url: `${hostUrl}/pages/CheckSaleExpense`,
              type: "GET",
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  //status==okay, proceed
                  result1 = confirm("confirm the changes made?");
                  if (!result1) {
                  } else {
                    //save to db
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecordEdit/${Recorddate}`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //redirect to index
                          location.replace(`${hostUrl}/pages/dailyreport`);
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                    location.replace(`${hostUrl}/pages/dailyreport`);
                  }
                } else if (dataResult.statusCode == 317) {
                  //status=not ok, proceed with warning, no sale
                  result2 = confirm("confirm changes made?");
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecordEdit/${Recorddate}`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //redirect to index
                          location.replace(`${hostUrl}/pages/dailyreport`);
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                    location.replace(`${hostUrl}/pages/dailyreport`);
                  }
                } else if (dataResult.statusCode == 318) {
                  //status=not ok, proceed with warning, no expense
                  result2 = confirm("confirm changes made?");
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    //save to db
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecordEdit/${Recorddate}`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //redirect to index
                          location.replace(`${hostUrl}/pages/dailyreport`);
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                    location.replace(`${hostUrl}/pages/dailyreport`);
                  }
                } else if (dataResult.statusCode == 319) {
                  //status=not ok, proceed with warning, no expense and sale
                  result2 = confirm("confirm changes made?");
                  if (!result2) {
                  } else {
                    //proceed to confirm sale page
                    $.ajax({
                      url: `${hostUrl}/pages/SaveSaleRecordEdit/${Recorddate}`,
                      type: "POST",
                      data: {
                        cybercash: cyberCash.value,
                        cybertill: cyberTill.value,
                        moviecash: movieCash.value,
                        movietill: movieTill.value,
                        pscash: psCash.value,
                        pstill: psTill.value,
                      },
                      dataType: "json",
                      success: function (dataResult) {
                        if (dataResult.statusCode == 200) {
                          //redirect to index
                          location.replace(`${hostUrl}/pages/dailyreport`);
                        } else if (dataResult.statusCode == 317) {
                          //not okay
                          document.querySelector(".alert").style.display =
                            "block";
                          document.getElementById("add-alert").style.color =
                            "#fff";
                          $("#add-alert").html(
                            "an error occurred, record could not be saved, please check your connection"
                          );

                          sleep(4700).then(() => {
                            document.querySelector(
                              ".alert_success"
                            ).style.display = "none";
                            document.getElementById("add-alert").innerHTML = "";
                          });
                        }
                      },
                    });
                    location.replace(`${hostUrl}/pages/dailyreport`);
                  }
                }
              },
            });
          }
        });
      });
    },
  },
  viewItem: {
    init: function _viewitem() {
      var threesixty = new ThreeSixty(document.getElementById("threesixty"), {
        image: document.getElementById("item-image").src,
        width: "60%",
        height: "50%",
        prev: document.getElementById("prev"),
        next: document.getElementById("next"),
      });

      threesixty.play();
    },
  },
  editItem: {
    init: function _edititem() {
      //increment stock
      itemQty = document.getElementById("item-quantity").value;

      document
        .getElementById("item-increase")
        .addEventListener("change", () => {
          var sum =
            parseInt(itemQty) +
            parseInt(document.getElementById("item-increase").value);
          document.getElementById("item-current-qty").value = sum;
        });

      document.getElementById("item-increase").addEventListener("input", () => {
        var sum =
          parseFloat(itemQty) +
          parseFloat(document.getElementById("item-increase").value);
        document.getElementById("item-current-qty").value = sum;
      });

      //edit inventory item
      $(document).ready(function () {
        $("form").on("submit", function (e) {
          e.preventDefault();
          //get values including file if exists
          var itemName = document.querySelector("#item-name");
          var itemQt = document.querySelector("#item-quantity");
          var itemBp = document.querySelector("#item-bp");
          var itemModel = document.querySelector("#model");
          itemImage = document.querySelector("#product-image");

          /*           var check = [itemName, itemQt, itemBp, itemModel].forEach((item) => {
            if (item.value == "") {
              item.style.border = "1.2px solid red";
              sleep(3500).then(() => {
                item.style.border = "";
              });
            }
            return false;
          }); */

          //product image
          var fd = new FormData();
          var files = $("#product-image")[0].files[0];
          fd.append("product-image", files);

          $.ajax({
            url: `${hostUrl}/pages/saveInventoryEdit/${
              document.getElementById("item-id").value
            }`,
            async: true,
            type: "POST",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData: false,
            dataType: "json",
            success: function (dataResult) {
              if (dataResult.statusCode == 200) {
                //remove alerts
                document.querySelector(".alert_success").style.display = "none";
                document.getElementsByClassName("loader")[0].style.display =
                  "block";

                sleep(2100).then(() => {
                  document.getElementsByClassName("loader")[0].style.display =
                    "none";
                  document.querySelector(".alert").style.display = "block";
                  document.getElementById("inventory-alert").style.display =
                    "block";
                  document.getElementById("inventory-alert").style.color =
                    "#fff";
                  document.getElementById("inventory-alert").innerHTML =
                    "changes saved successfully!";

                  $("#product-avatar").attr(
                    "src",
                    `${hostUrl}/public/images/images/open-box.png`
                  );
                  document.getElementById("product-image").value = "";
                  sleep(3500).then(() => {
                    document.querySelector(".alert_success").style.display =
                      "none";
                    document.getElementById("inventory-alert").innerHTML = "";
                  });

                  // location.replace(`${hostUrl}/pages/dailyreport`);
                });
              } else if (dataResult.statusCode == 201) {
                document.querySelector(".alert").style.display = "block";
                document.getElementById("inventory-alert").style.color =
                  "#f85f5f";
                $("#inventory-alert").html(
                  "invalid file or missing field, please try again"
                );

                sleep(4700).then(() => {
                  document.querySelector(".alert_success").style.display =
                    "none";
                  document.getElementById("inventory-alert").innerHTML = "";
                });
              } else if (dataResult.statusCode == 417) {
                document.querySelector(".alert").style.display = "block";
                document.getElementById("inventory-alert").style.color =
                  "#f85f5f";
                $("#inventory-alert").html(
                  "request could not be completed, check your connection"
                );

                sleep(4700).then(() => {
                  document.querySelector(".alert_success").style.display =
                    "none";
                  document.getElementById("inventory-alert").innerHTML = "";
                });
              }
            },
          });
        });
      });
    },
  },
  removeItem: {
    init: function _removeitem() {
      var cancel = document.getElementById("cancel-remove");
      var accept = document.getElementById("accept-remove");

      $("#cancel-remove").click(function (e) {
        history.back();
      });
      $("#accept-remove").click(function (e) {
        //delete item
        var id = document.getElementById("item-id").value;
        $.ajax({
          url: `${hostUrl}/pages/DeleteItem`,
          type: "POST",
          data: {
            ID: id,
          },
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              history.back();
            } else {
              document.querySelector(".alert").style.display = "block";
              document.getElementById("add-alert").style.color = "#fff";
              $("#add-alert").html(
                "an error occurred, item could not be removed, please check your connection"
              );

              sleep(4700).then(() => {
                document.querySelector(".alert_success").style.display = "none";
                document.getElementById("add-alert").innerHTML = "";
              });
            }
          },
        });
      });
    },
  },
  deleteRecord: {
    init: function _deleterecord() {
      var cancel = document.getElementById("cancel-remove");
      var accept = document.getElementById("accept-remove");

      $("#cancel-remove").click(function (e) {
        location.replace(`${hostUrl}/pages/dailyreport`);
      });
      $("#password").on("keyup", function (e) {
        if (e.key === "Enter" || e.keyCode === 13) {
          var id = document.getElementById("item-id").value;
          var password = document.getElementById("password").value;
          var date = document.getElementById("date-").value;
          $.ajax({
            url: `${hostUrl}/pages/DeleteRecordAll`,
            type: "POST",
            data: {
              ID: id,
              Password: password,
              Date: date,
            },
            dataType: "json",
            success: function (dataResult) {
              if (dataResult.statusCode == 200) {
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  location.replace(`${hostUrl}/pages/dailyreport`);
                });
              } else if (dataResult.statusCode == 317) {
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  document.querySelector(".text-").style.display = "block";
                  $(".text-").html(
                    "an error occurred, record could not be deleted, please check your connection"
                  );
                });

                sleep(8100).then(() => {
                  document.querySelector(".text-").style.display = "none";
                });
              } else if (dataResult.statusCode == 300) {
                document.querySelector(".text-").style.display = "none";
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  document.querySelector(".text-").style.display = "block";
                  $(".text-").html("Incorrect password, please try again");
                });
                sleep(8100).then(() => {
                  document.querySelector(".text-").style.display = "none";
                });
              }
            },
          });
        }
      });
      $("#accept-remove").click(function (e) {
        //confirm password
        var id = document.getElementById("item-id").value;
        var password = document.getElementById("password").value;
        var date = document.getElementById("date-").value;
        $.ajax({
          url: `${hostUrl}/pages/DeleteRecordAll`,
          type: "POST",
          data: {
            ID: id,
            Password: password,
            Date: date,
          },
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                location.replace(`${hostUrl}/pages/dailyreport`);
              });
            } else if (dataResult.statusCode == 317) {
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                document.querySelector(".text-").style.display = "block";
                $(".text-").html(
                  "an error occurred, record could not be deleted, please check your connection"
                );
              });

              sleep(8100).then(() => {
                document.querySelector(".text-").style.display = "none";
              });
            } else if (dataResult.statusCode == 300) {
              document.querySelector(".text-").style.display = "none";
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                document.querySelector(".text-").style.display = "block";
                $(".text-").html("Incorrect password, please try again");
              });
              sleep(8100).then(() => {
                document.querySelector(".text-").style.display = "none";
              });
            }
          },
        });
      });
    },
  },
  __cashOut: {
    init: function _cashout() {
      function makeid(length) {
        var result = "";
        var characters =
          "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
          result += characters.charAt(
            Math.floor(Math.random() * charactersLength)
          );
        }
        return result;
      }

      document.getElementById("receipt-num").value = makeid(8);

      $("form").on("submit", function (e) {
        e.preventDefault();
        //submit to receipt
        var amount = document.getElementById("amount").value;
        var usage = document.getElementById("usage").value;
        var cashFrom = document.getElementById("cash-from").value;
        var date = document.getElementById("date-").value;
        var handler = document.getElementById("handler").value;
        var receipt = document.getElementById("receipt-num").value;

        cash = [amount, usage, cashFrom, date, handler, receipt];
        console.log(cash);
        $.ajax({
          url: `${hostUrl}/pages/cashReceipt/${cash}`,
          type: "POST",
        });
        location.replace(`${hostUrl}/pages/cashReceipt/${cash}`);
      });
    },
  },
  __cashReceipt: {
    init: function _cashreceipt() {
      $("#save-cashout").click(function (e) {
        //load
        document.getElementsByClassName("load-wrapp")[0].style.display =
          "block";

        var amount = document.getElementById("amount").value;
        var usage = document.getElementById("usage").value;
        var cashFrom = document.getElementById("from").value;
        var date = document.getElementById("date__").value;
        var handler = document.getElementById("handler").value;
        var receipt = document.getElementById("receipt").value;

        $.ajax({
          url: `${hostUrl}/pages/saveCashout`,
          type: "POST",
          data: {
            Amount: amount,
            Usage: usage,
            From: cashFrom,
            Date: date,
            Handler: handler,
            Receipt: receipt,
          },
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              if (cashFrom === "movie") {
                location.replace(`${hostUrl}/pages/movieShop`);
              } else if (cashFrom === "ps") {
                location.replace(`${hostUrl}/pages/playstation`);
              } else if (cashFrom === "cyber") {
                location.replace(`${hostUrl}/pages/cyber`);
              } else if (cashFrom === "sales") {
                location.replace(`${hostUrl}/pages/sales`);
              } else if (cashFrom === "total") {
                location.replace(`${hostUrl}/pages/total`);
              }
            } else if (dataResult.statusCode == 318) {
              document.getElementsByClassName("load-wrapp")[0].style.display =
                "none";
              document.querySelector(".alert_failed").style.display = "block";
              $("#add-alert").html(
                `The requested station does not have enough money to make that cashout, please try another station`
              );
              sleep(4700).then(() => {
                document.querySelector(".alert_failed").style.display = "none";
                $("#add-alert").html("");
              });
            } else if (dataResult.statusCode == 317) {
              document.getElementsByClassName("load-wrapp")[0].style.display =
                "none";
              document.querySelector(".alert_failed").style.display = "block";
              $("#add-alert").html("connection error, please try again");
              sleep(4700).then(() => {
                document.querySelector(".alert_failed").style.display = "none";
                $("#add-alert").html("");
              });
            }
          },
        });
      });
    },
  },
  __list: {
    init: function _list() {
      FilterInventory();
      /* $("#filter-list").on("keyup", function () {
        var value = this.value.toLowerCase().trim();
        $(".list p")
          .show()
          .filter(function () {
            return $(this).text().toLowerCase().trim().indexOf(value) == -1;
          })
          .hide();
      }); */
    },
  },
  __attatchReceipt: {
    init: function _receipt() {},
  },
  __date: {
    init: function _date() {},
  },
  __cashouts: {
    init: function _cashouts() {
      (function (document) {
        "use strict";

        var LightTableFilter = (function (Arr) {
          var _input;

          function _onInputEvent(e) {
            _input = e.target;
            var tables = document.getElementsByClassName(
              _input.getAttribute("data-table")
            );
            Arr.forEach.call(tables, function (table) {
              Arr.forEach.call(table.tBodies, function (tbody) {
                Arr.forEach.call(tbody.rows, _filter);
              });
            });
          }

          function _filter(row) {
            var text = row.textContent.toLowerCase(),
              val = _input.value.toLowerCase();
            row.style.display = text.indexOf(val) === -1 ? "none" : "table-row";
          }

          return {
            init: function () {
              var inputs = document.getElementsByClassName("cashouts-filter");
              Arr.forEach.call(inputs, function (input) {
                input.oninput = _onInputEvent;
              });
            },
          };
        })(Array.prototype);

        document.addEventListener("readystatechange", function () {
          if (document.readyState === "complete") {
            LightTableFilter.init();
          }
        });
      })(document);
    },
  },
  __deleteCashout: {
    init: function _deleterecord() {
      var cancel = document.getElementById("cancel-remove");
      var accept = document.getElementById("accept-remove");

      $("#cancel-remove").click(function (e) {
        location.replace(`${hostUrl}/pages/cashouts`);
      });
      $("#password").on("keyup", function (event) {
        if (event.keyCode === 13) {
          //confirm password
          var id = document.getElementById("item-id").value;
          var password = document.getElementById("password").value;
          $.ajax({
            url: `${hostUrl}/pages/DeleteCashoutAll`,
            type: "POST",
            data: {
              ID: id,
              Password: password,
            },
            dataType: "json",
            success: function (dataResult) {
              if (dataResult.statusCode == 200) {
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  location.replace(`${hostUrl}/pages/cashouts`);
                });
              } else if (dataResult.statusCode == 317) {
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  document.querySelector(".text-").style.display = "block";
                  $(".text-").html(
                    "an error occurred, record could not be deleted, please check your connection"
                  );
                });

                sleep(8100).then(() => {
                  document.querySelector(".text-").style.display = "none";
                });
              } else if (dataResult.statusCode == 300) {
                document.querySelector(".text-").style.display = "none";
                document.getElementById("deleteloader").style.display = "block";
                sleep(4000).then(() => {
                  document.getElementById("deleteloader").style.display =
                    "none";
                  document.querySelector(".text-").style.display = "block";
                  $(".text-").html("Incorrect password, please try again");
                });
                sleep(8100).then(() => {
                  document.querySelector(".text-").style.display = "none";
                });
              }
            },
          });
        }
      });

      $("#accept-remove").click(function (e) {
        //confirm password
        var id = document.getElementById("item-id").value;
        var password = document.getElementById("password").value;
        $.ajax({
          url: `${hostUrl}/pages/DeleteCashoutAll`,
          type: "POST",
          data: {
            ID: id,
            Password: password,
          },
          dataType: "json",
          success: function (dataResult) {
            if (dataResult.statusCode == 200) {
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                location.replace(`${hostUrl}/pages/cashouts`);
              });
            } else if (dataResult.statusCode == 317) {
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                document.querySelector(".text-").style.display = "block";
                $(".text-").html(
                  "an error occurred, record could not be deleted, please check your connection"
                );
              });

              sleep(8100).then(() => {
                document.querySelector(".text-").style.display = "none";
              });
            } else if (dataResult.statusCode == 300) {
              document.querySelector(".text-").style.display = "none";
              document.getElementById("deleteloader").style.display = "block";
              sleep(4000).then(() => {
                document.getElementById("deleteloader").style.display = "none";
                document.querySelector(".text-").style.display = "block";
                $(".text-").html("Incorrect password, please try again");
              });
              sleep(8100).then(() => {
                document.querySelector(".text-").style.display = "none";
              });
            }
          },
        });
      });
    },
  },
  __invoices: {
    init: function _invoices() {
      //search
      $("#search-").click(function (e) {
        if (document.getElementById("invoice-item").value != "") {
          $("#invoice-result").html("");
          $("#invoice-loading").fadeIn();
          sleep(2200).then(() => {
            //load results onto div
            $("#invoice-loading").fadeOut();
            $.ajax({
              url: `${hostUrl}/pages/loadInvoiceSearch/${
                document.getElementById("invoice-item").value
              }`,
              type: "GET",
              dataType: "json",
              success: function (dataResult) {
                if (dataResult.statusCode == 200) {
                  var string = `
                  <table class="table table-striped table-cashouts">
                  <thead>
                      <tr>
                          <th> Date </th>
                          <th> Sales Item </th>
                          <th> Buying Price </th>
                          <th> Selling Price </th>
                          <th> Profit </th>
                          <th> Invoice </th>
                      </tr>
                  </thead>
                  <tbody>
                  `;
                  dataResult.row.forEach((exp) => {
                    string += `
                    <tr>
                    <th>${exp.date_created}</th>
                    <th>${exp.sales_item}</th>
                    <th>${exp.buying_price}</th>
                    <th>${exp.selling_price}</th>
                    <th>${exp.profit}</th>
                    <th><a href=${hostUrl}/pages/invoice/sale/${exp.sales_id}>invoice</a></th>
                    </tr>
                    `;
                    $("#invoice-result").html(string);
                  });
                } else {
                  var stringErr = "";
                  stringErr += `<p class="text-danger">record could not be foind, check your connection and try again</p>`;
                  $("#invoice-result").html(stringErr);
                }
              },
            });
          });
        } else {
          document.getElementById("invoice-item").style.border =
            "1px solid red";
          sleep(2500).then(() => {
            document.getElementById("invoice-item").style.border = "";
          });
        }
      });
      //on enter
      $("#invoice-item").on("keyup", function (event) {
        if (event.keyCode === 13) {
          if (document.getElementById("invoice-item").value != "") {
            $("#invoice-result").html("");
            $("#invoice-loading").fadeIn();
            sleep(2200).then(() => {
              //load results onto div
              $("#invoice-loading").fadeOut();
              $.ajax({
                url: `${hostUrl}/pages/loadInvoiceSearch/${
                  document.getElementById("invoice-item").value
                }`,
                type: "GET",
                dataType: "json",
                success: function (dataResult) {
                  if (dataResult.statusCode == 200) {
                    var string = `
                    <table class="table table-striped table-cashouts">
                    <thead>
                        <tr>
                            <th> Date </th>
                            <th> Sales Item </th>
                            <th> Buying Price </th>
                            <th> Selling Price </th>
                            <th> Profit </th>
                            <th> Invoice </th>
                        </tr>
                    </thead>
                    <tbody>
                    `;
                    dataResult.row.forEach((exp) => {
                      string += `
                      <tr>
                      <th>${exp.date_created}</th>
                      <th>${exp.sales_item}</th>
                      <th>${exp.buying_price}</th>
                      <th>${exp.selling_price}</th>
                      <th>${exp.profit}</th>
                      <th><a href=${hostUrl}/pages/invoice/sale/${exp.sales_id}>invoice</a></th>
                      </tr>
                      `;
                      $("#invoice-result").html(string);
                    });
                  } else {
                    var stringErr = "";
                    stringErr += `<p class="text-danger">record could not be foind, check your connection and try again</p>`;
                    $("#invoice-result").html(stringErr);
                  }
                },
              });
            });
          } else {
            document.getElementById("invoice-item").style.border =
              "1px solid red";
            sleep(2500).then(() => {
              document.getElementById("invoice-item").style.border = "";
            });
          }
        }
      });
    },
  },
  __profiler: {
    init: function _profile() {
      $("#save-profile").click(function (e) {
        $("#profile-loading").fadeIn();
        sleep(2200).then(() => {
          $("#profile-loading").fadeOut();
          $.ajax({
            url: `${hostUrl}/Users/saveProfile`,
            type: "POST",
            data: {
              username: document.getElementById("username").value,
              email: document.getElementById("email").value,
              oldPassword: document.getElementById("old").value,
              newPassword: document.getElementById("new").value,
            },
            dataType: "json",
            success: function (dataResult) {
              if (dataResult.statusCode == 200) {
                console.log("200");
                var string = `
                <div class="card bg-gradient-success">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>Success!</strong> Profile has been saved.
                </div>
                `;
                $("#profile-result").html(string);
              } else if (dataResult.statusCode == 201) {
                console.log("201");
                var stringErr = "";
                stringErr += `<p class="text-danger">record could not be found, check your connection and try again</p>`;
                $("#profile-result").html(stringErr);
              } else if (dataResult.statusCode == 317) {
                console.log("317");
                var stringErr = "";
                stringErr += `<div class="card bg-gradient-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!</strong> Incorrect password, please try again.
              </div>`;
                $("#profile-result").html(stringErr);
              }
            },
          });
        });
      });
    },
  },
};
