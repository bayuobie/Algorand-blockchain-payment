/* Conversion Price Configs
 * Change the value of the contant below to your preferred price option
 * [lastPrice / bidPrice / askPrice / openPrice / highPrice / lowPrice]
 * Also replace the merchAlgoAddress with a valid Algorand Address
 */
const convPrice = "bidPrice";
const merchAlgoAddress = "HIPB2IEVJ43VG66VFGBMIWNBHPIPXI6EDIOFNB3BN2E2KHWNPYDK2CJ24I";
const merchCallbackURL = "./?"; // Replace this with your preferred callback URL and add '?' at the end
const authTimeOutMils = 300000; //in mili-Seconds
const authTimeOutSecs = 30; //in Seconds

var cardDrop = document.getElementById('card-dropdown');
var activeDropdown;
cardDrop.addEventListener('click',function(){
  var node;
  for (var i = 0; i < this.childNodes.length-1; i++)
    node = this.childNodes[i];
    if (node.className === 'dropdown-select') {
      node.classList.add('visible');
       activeDropdown = node; 
    };
})

window.onclick = function(e) {
  if (e.target.tagName === 'LI' && activeDropdown){
    if (e.target.innerHTML === 'USDC') {
      activeDropdown.classList.remove('visible');
      activeDropdown = null;
      e.target.innerHTML = document.getElementById('current-card').innerHTML;
      document.getElementById('current-card').innerHTML = 'USDC';

      document.getElementById('cryptSymbol').value = 'BTCUSDT';
      convertBill();
    }
    else if (e.target.innerHTML === 'Planets') {
      activeDropdown.classList.remove('visible');
      activeDropdown = null;
      e.target.innerHTML = document.getElementById('current-card').innerHTML;
      document.getElementById('current-card').innerHTML = 'OKEx'; 
      document.getElementById('cryptSymbol').value = 'Planets';
      convertBill();    
    }
    else if (e.target.innerHTML === 'ALGO') {
      activeDropdown.classList.remove('visible');
      activeDropdown = null;
      e.target.innerHTML = document.getElementById('current-card').innerHTML;
      document.getElementById('current-card').innerHTML = 'ALGO';
      document.getElementById('cryptSymbol').value = 'ALGOUSDT';
      convertBill();
    }
  }
  else if (e.target.className !== 'dropdown-btn' && activeDropdown) {
    activeDropdown.classList.remove('visible');
    activeDropdown = null;
  }
}

function genRandomID(length) {
   var result           = '';
   var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}