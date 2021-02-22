import { Transaction } from './classes/Transaction.js';
import { TransactionService } from './classes/TransactionService.js';
import { ListTemplate } from './classes/ListTemplate.js';

const form = document.querySelector('.form-inline') as HTMLFormElement;
const type = document.querySelector('#type') as HTMLInputElement;

const ul = document.querySelector('ul')!;
const list = new ListTemplate(ul);

form.addEventListener('submit', (e: Event) => {
  e.preventDefault();
  let targetFile = {"fileName":type.value};
  let transactionService = new TransactionService(list, targetFile);
  transactionService.call();
});