// SPDX-License-Identifier: MIT
pragma solidity ^0.8.0;
import "@openzeppelin/contracts/utils/math/SafeMath.sol";
import "@openzeppelin/contracts/token/ERC20/ERC20.sol";
import "@openzeppelin/contracts/token/ERC20/utils/SafeERC20.sol";
//import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v3.3.0/contracts/math/SafeMath.sol";
//import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v3.3.0/contracts/token/ERC20/SafeERC20.sol";
//import "https://github.com/OpenZeppelin/openzeppelin-contracts/blob/v3.3.0/contracts/token/ERC20/ERC20.sol";

contract USD_CP is ERC20, SafeERC20 {

using SafeMath for uint256;

address public constant BEP20_ADDRESS = 0xA3378bd30f9153aC12AFF64743841f4AFa29bC57;
address public constant PANCAKESWAP_ADDRESS = 0xfbd61b037c325b959c0f6a7e69d8f37770c2c550;

uint256 public constant EXCHANGE_RATE = 1;

string public constant name = "USD-CP";
string public constant symbol = "USD-CP";
uint8 public constant decimals = 18;

mapping (address => uint256) private _balances;
mapping (address => mapping (address => uint256)) private _allowances;

function totalSupply() public view returns (uint256) {
return _balances[address(0)];
}

function balanceOf(address account) public view returns (uint256) {
return _balances[account];
}

function transfer(address to, uint256 value) public returns (bool) {
require(_balances[msg.sender] >= value && value > 0, "transfer failed");
_balances[msg.sender] = _balances[msg.sender].sub(value);
_balances[to] = _balances[to].add(value);
emit Transfer(msg.sender, to, value);
return true;
}

function approve(address spender, uint256 value) public returns (bool) {
_allowances[msg.sender][spender] = value;
emit Approval(msg.sender, spender, value);
return true;
}

function transferFrom(address from, address to, uint256 value) public returns (bool) {
require(_balances[from] >= value && _allowances[from][msg.sender] >= value && value > 0, "transferFrom failed");
_balances[from] = _balances[from].sub(value);
_allowances[from][msg.sender] = _allowances[from][msg.sender].sub(value);
_balances[to] = _balances[to].add(value);
emit Transfer(from, to, value);
return true;
}

function exchangeRate() public view returns (uint256) {
return EXCHANGE_RATE;
}


event Transfer(address indexed from, address indexed to, uint256 value);
event Approval(address indexed owner, address indexed spender, uint256 value);

// Add a function to retrieve the current BEP20 token price
function getBEP20Price() public view returns (uint256) {
// Call the getPrice function of the PancakeSwap router
return uint256(address(PANCAKESWAP_ADDRESS).call("getPrice", BEP20_ADDRESS));
}

// Add a function to update the exchange rate of USD-CP to match the current price of BEP20
function updateExchangeRate() public {
// Call the getBEP20Price function to retrieve the current BEP20 price
uint256 currentBEP20Price = getBEP20Price();
// Set the exchange rate to the current BEP20 price divided by 1 USD
EXCHANGE_RATE = currentBEP20Price / 1 ether;
}


// Add a function to issue new USD-CP tokens based on the current exchange rate
function issue(uint256 value) public {
// Calculate the amount of BEP20 tokens required to issue the specified amount of USD-CP tokens
uint256 requiredBEP20Amount = value * EXCHANGE_RATE;
// Call the transfer function of the BEP20 token contract to transfer the required amount of BEP20 tokens to this contract
require(address(BEP20_ADDRESS).call.value(requiredBEP20Amount).gas(21000)(""), "issue failed");
// Add the newly issued USD-CP tokens to the total supply
_balances[address(0)] = _balances[address(0)].add(value);
// Add the newly issued USD-CP tokens to the balance of the caller
_balances[msg.sender] = _balances[msg.sender].add(value);
emit Transfer(address(0), msg.sender, value);
}

// Add a function to redeem USD-CP tokens for BEP20 tokens
function redeem(uint256 value) public {
// Require that the caller has the specified amount of USD-CP tokens
require(_balances[msg.sender] >= value && value > 0, "redeem failed");
// Calculate the amount of BEP20 tokens that will be received for the specified amount of USD-CP tokens
uint256 receivedBEP20Amount = value * EXCHANGE_RATE;
// Call the transfer function of the BEP20 token contract to transfer the received amount of BEP20 tokens to the caller
require(address(BEP20_ADDRESS).call.value(receivedBEP20Amount).gas(21000)(""), "redeem failed");
// Remove the redeemed USD-CP tokens from the total supply
_balances[address(0)] = _balances[address(0)].sub(value);
// Remove the redeemed USD-CP tokens from the balance of the caller
_balances[msg.sender] = _balances[msg.sender].sub(value);
emit Transfer(msg.sender, address(0), value);
}

}
