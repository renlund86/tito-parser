import { Transaction } from './Transaction.js';
import { ListTemplate } from './ListTemplate.js';

export class TransactionService {
    constructor(
        public list: ListTemplate,
        public data: any
    ){}

  call() {
    let transaction;
    
    this.list.clearList();

    window.fetch('http://tito-test.mrenlund.com/parse', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify(this.data),
      })
      .then((resp) => resp.json())
      .then((respData) => {
          respData.forEach((element:any, index:any) => {
            transaction = new Transaction(
                element.recordLength,
                element.transactionNo,
                element.archiveCode,
                element.entryDate,
                element.valueDate,
                element.paymentDate,
                element.transactionType,
                element.transactionReasonCode,
                element.transactionReasonCodeTranslation,
                element.transactionReasonDescription,
                element.transactionAmountFormatted,
                element.voucherCode,
                element.transmissionFacility,
                element.payerName,
                element.payerNameSource,
                element.payerAccount,
                element.payerAccountChanged,
                element.referenceNumber,
                element.formNumber,
                element.levelCode
            );
            this.list.render(transaction, 'end');
          });
      });
  }

}