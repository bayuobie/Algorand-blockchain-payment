<?php
session_start();
require_once("dbcontroller.php");
?>

<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AlgoPay Checkout — Test</title>
  <link rel="icon" type="image/png" href="img/algo.png"/>
  <link rel="stylesheet" href="./css/style.css">
  <script src="algosdk.min.js"></script>
</head>
<body>
<div id="loader"></div>

<div class='container'>
  <div class='window' id="main">
    <div class='order-info'>
      <div class='order-info-content'>
        <h2 id="order-info-title">Order Summary</h2>
        <div class='line'></div>
        <table class='order-table'>
          <tbody>
            <?php 
              if(isset($_SESSION["cart_item"])){
              $total_quantity = 0;
              $total_price = 0;  
              foreach ($_SESSION["cart_item"] as $item){
              $item_price = $item["quantity"]*$item["price"];
            ?>
              <tr style="">
                <td><img src='<?php echo $item["image"]; ?>' class='full-width'></img>
                </td>
                <td>
                  <br> <span class='thin'><?php echo $item["name"]; ?></span>
                  <br> <span class='thin small'><?php echo $item["quantity"]; ?> x <?php echo "$ ".$item["price"]; ?>
                    <span style="float: right;"><b><?php echo "$ ". number_format($item_price,2); ?></b></span>
                  </span>
                </td>
              </tr>
            <?php
              $total_quantity += $item["quantity"];
              $total_price += ($item["price"]*$item["quantity"]);
            }
            ?>

            <?php } else { ?>
            <tr>
              <td><img src='./img/empty-cart.png' class='full-width'></img>
              </td>
              <td>
                <br> <span class='thin'>Sorry!</span>
                <br> <span class='thin small'> Your Cart is Empty.<br>« back to <a href="./" style="color: black;">Shopping Page</a></span>
              </td>
            </tr>
            <?php  } ?>
            
          </tbody>

        </table>

        <div class='total'>
          <?php if(isset($_SESSION["cart_item"])){ ?>
          <div class='line'></div>
          <span style='float:left;'>
            <div class='thin dense'>Discount 0%</div>
            <div class='thin dense'>Delivery</div>
            TOTAL
          </span>
          <span style='float:right; text-align:right;'>
            <div class='thin dense'>$00.00</div>
            <div class='thin dense'><i>NULL</i></div>
            <?php echo "$ ". number_format($total_price,2); ?>
          </span>

          <input type="text" id="cryptSymbol" value="ALGOUSDT" hidden="" onchange="convertBill()" />
          <input type="text" id="billAmt" value="<?=$total_price?>" style="background: none; border: none; outline: none;" hidden />
          <?php  } ?>
        </div>
      </div>
    </div>
        <div class='credit-info'>
          <?php if(isset($_SESSION["cart_item"])){ ?>
          <div class='credit-info-content'>
            <table class='half-input-table'>
              <tr><td>Select Payment Option: </td><td><div class='dropdown' id='card-dropdown'><div class='dropdown-btn' id='current-card'>ALGO</div>
                <div class='dropdown-select'>
                <ul>
                  <li>Telos</li>
                  <li>OKEx</li>
                  </ul></div>
                </div>
               </td></tr>
            </table>
            <div class='line'></div>
            <?php /* <img src='./img/algorand.jpg' height='80' class='credit-card-image' id='credit-card-image'></img> */ ?>

            Full Name
            <input class='input-field' id="full-name"></input>
            Your Algorand Address
            <input class='input-field' id="cryptoAddress"></input>
            Your Mnemonic Code
            <textarea class='input-field' id="cryptoMnemonic" rows="3"></textarea>

            <span id="prefCrypto">Ammount Due:</span>
            <input class='input-field' id="convertedRate" readonly="" style="outline: none; background: rgba(255,255,255, 0.3);"></input>
            <button class='pay-btn' onclick="proceedCheckout()">» Proceed</button>

            <div id="cryptoResults">{Results}</div>

          </div>
          <?php  } ?>
        </div>
      </div>
</div>
<!-- partial -->

<?php if(isset($_SESSION["cart_item"])){ ?>
<a href="#open-modal" id="om-anchor"></a>
<a href="#" id="om-close-anchor"></a>
<input type="text" id="order-id" hidden="">
<input type="text" id="tx-id" hidden="">
<div id="open-modal" class="modal-window">
  <div id="modal-container">
    <a href="#" title="Close" class="modal-close">Close</a>
    <h1 id="om-title">{omTitle}</h1>
    <div id="om-body">{omBody}</div>
    <hr>
    <div id="om-support">
      <small id="sup-small">Need Help?</small><br>
      📧 Email: <a href="mailto:support@algorand.com" style="color: black;" target="_blank">support@algorand.com</a>
    </div>
  </div>
</div>
<?php  } ?>

  <script src="./js/jquery-3.4.1.min.js"></script>
  <script  src="./js/script.js"></script>

  <script type="text/javascript">
    window.onload = function() {
      //cryptSymbol = 'ALGOUSDT';
      const orderID = genRandomID(7);

      <?php if(isset($_SESSION["cart_item"])){ ?>
      $("#order-id").val(orderID);
      $("#order-info-title").html('#'+orderID+' | Order Summary');
      <?php  } ?>

      showLoader();
      convertBill();
    };
    
    function convertBill() {
      $('.credit-info').fadeTo("slow", 0.5).css('pointer-events', 'none');
      var bAmount = $("#billAmt").val();
      var targetSymbol = $("#cryptSymbol").val();
      var count = 0;
      var filtered_json = [];
      $.ajax({
        type: "POST",
        url: "./inc/binance-alt.php",
        data: {  },
        success: function(resp) {
          var jsonData = JSON.parse(resp);
          for (var i = 0; i < jsonData.length; i++) {
              if(jsonData[i]['symbol'] == targetSymbol){
                  count++;
                  filtered_json.push(jsonData[i]);
              }
          }
          //console.log(filtered_json);
          var filterList = filtered_json;
          $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
          console.log(filtered_json);

          $('#prefCrypto').html('Ammount Due ['+filtered_json[0].symbol+']:');
          $('#cryptoResults').html('Rate :: '+filtered_json[0].symbol+' /// '+ filtered_json[0][convPrice]);
          $("#convertedRate").val((parseFloat(bAmount)/filtered_json[0][convPrice]));

        }
      }); 
    }

    function proceedCheckout() {
      $('.credit-info').fadeTo("slow", 0.5).css('pointer-events', 'none');
      var targetSymbol = $("#cryptSymbol").val();
      var cAmount = $("#convertedRate").val();
      var amtToInt = parseFloat(cAmount);
      var amtFinal = amtToInt.toFixed(2);
      var uFullName = $("#full-name").val();
      var cAddress = $("#cryptoAddress").val();
      var cMnemonic = $("#cryptoMnemonic").val(); 
      var cOrderID = $("#order-id").val();
      var jsonRes = [];
      if (uFullName!=='' && cAddress!=='') {

        if (targetSymbol==='ALGOUSDT') {
          $.ajax({
            type: "GET",
            url: "https://api.algoexplorer.io/v2/accounts/"+cAddress,
            data: {  },
            success: function(resp) {
              jsonRes.push(resp);
              console.log(jsonRes);
              if(cAddress===jsonRes[0].address){
                //const algosdk = require('algosdk');
                const baseServer = "https://testnet-algorand.api.purestake.io/ps1"
                const port = "";
                const token = {
                    'X-API-key' : 'b0r9BtPAG64Adngz6DO6e6wo4FhQenSw1OUpXLHT',
                }

                const algodclient = new algosdk.Algod(token, baseServer, port); 
                var recoveredAccount = algosdk.mnemonicToSecretKey(cMnemonic); 
                console.log(recoveredAccount.addr);


                (async() => {

                    let params = await algodclient.getTransactionParams();
                    let endRound = params.lastRound + parseInt(1000);
                    var jsonNote = '{"oderID":"'+cOrderID+'", "fullName":"'+uFullName+'",';
                      <?php foreach ($_SESSION["cart_item"] as $item){extract($item);?>jsonNote +='"item_<?=$code?>": { "name":"<?=$name?>", "qty":"<?=$quantity?>", "price_usd":"<?=$price?>", }';<?php }?>
                    jsonNote +='}';
                    let newJSONNote ='';

                    let txn = {
                        "from": recoveredAccount.addr,
                        "to": merchAlgoAddress,
                        "fee": 1,
                        "amount": (amtFinal*1000000), //amtFinal
                        "firstRound": params.lastRound,
                        "lastRound": endRound,
                        "genesisID": params.genesisID,
                        "genesisHash": params.genesishashb64,
                        "note": algosdk.encodeObj(jsonNote),
                    };

                    const txHeaders = {
                        'Content-Type' : 'application/x-binary'
                    }
                    let signedTxn = algosdk.signTransaction(txn, recoveredAccount.sk);
                    let tx = (await algodclient.sendRawTransaction(signedTxn.blob, txHeaders));
                    console.log("Transaction : " + tx.txId);
                    $("#tx-id").val(tx.txId);

                    // onSuccess
                    $("#om-anchor")[0].click()
                    $('#om-title').html('Voilá!');
                    document.getElementById('om-title').style = 'color: #22a877;';
                    $('#om-body').html('Payment of <code style="color:#22a877 !important">'+amtFinal+'</code> ALGOs to the Algorand Address below:<br><code style="color:#227fad !important">'+merchAlgoAddress+'</code><br>has been successful.');

                    $('#om-support').hide();
                    $('.modal-close').html('Done');
                    $(".modal-close").attr("href", "javascript:;").attr("onclick", "confirmPayment()");
                    $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
                    confirmPayment();

                })().catch(e => {
                    console.log(e);

                    // onError
                    $("#om-anchor")[0].click()
                    $('#om-title').html('Sorry!');
                    document.getElementById('om-title').style = 'color: rgb(236, 49, 49);';
                    $('#om-body').html('Sorry! An Error occurred.<br>Please provide a valid Algorand details.');

                    $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
                });

              } else {

                $("#om-anchor")[0].click()
                $('#om-title').html('Sorry!');
                document.getElementById('om-title').style = 'color: rgb(236, 49, 49);';
                $('#om-body').html('Please provide a valid Algorand Address.');

                $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
              }
              
            },
            error: function (xhr, ajaxOptions, thrownError) {
              $("#om-anchor")[0].click()
              $('#om-title').html('Sorry!');
              document.getElementById('om-title').style = 'color: rgb(236, 49, 49);';
              $('#om-body').html('Please provide a valid Algorand Address.');
              
              $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
            }
          });
        } else { 
          alert('Sorry! Service Unavailable for: '+targetSymbol); 
          $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
        }
        
      } else {
        $('.credit-info').fadeTo("slow", 1).css('pointer-events', 'auto');
        //alert('All Fields are Required!');
        $("#om-anchor")[0].click();
        $('#om-title').html('Oops!');
        document.getElementById('om-title').style = 'color: rgb(236, 49, 49);';
        $('#om-body').html('Please provide valid details for the highlighted fields.');
        if (uFullName==='') { document.getElementById('full-name').style = 'outline: #f05959 dashed 1px;'; }
        if (cAddress==='') { document.getElementById('cryptoAddress').style = 'outline: #f05959 dashed 1px;'; }
      }
      
    }

    var myVar;

    function showLoader() {
      myVar = setTimeout(showPage, 2500);
    }

    function showPage() {
      document.getElementById("loader").style.display = "none";
      document.getElementById("main").style.opacity = "1";
      document.getElementById("main").style.transition = "1s ease";
    }

    function confirmPayment() {
      var oxID = $("#order-id").val();
      var txID = $("#tx-id").val();
      if ($("#progress").length === 0) {
        // inject the bar..
        $("#modal-container").append($("<div><b></b><i></i></div>").attr("id", "progress"));
        
        // animate the progress..
        $("#progress").width("101%").delay(800).fadeOut(1000, function() {
          // ..then remove it. | om-close-anchor
          $("#om-close-anchor")[0].click();
          $("#main").html('<center><img src="./success-anim-1.gif" style="width: 100%; height: 100%; object-fit: cover;display:-webkit-box; display:-webkit-flex; display:-ms-flexbox; display:flex;"></center>').delay(800).fadeOut(1000, function() {
            location.replace(merchCallbackURL+"oxID="+oxID+"&txID="+txID);
          });
          $(this).remove();
        });  
      }
    }
  </script>
</body>
</html>
