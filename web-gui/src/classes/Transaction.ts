import { HasFormatter } from "../interfaces/HasFormatter";

export class Transaction implements HasFormatter {

constructor(
  private recordLength:string, 
  private transactionNo:string, 
  private archiveCode:string, 
  private entryDate:string, 
  private valueDate:string, 
  private paymentDate:string, 
  private transactionType:string, 
  private transactionReasonCode:string, 
  private transactionReasonCodeTranslation:string, 
  private transactionReasonDescription:string, 
  private transactionAmountFormatted:string, 
  private voucherCode:string, 
  private transmissionFacility:string, 
  private payerName:string, 
  private payerNameSource:string, 
  private payerAccount:string, 
  private payerAccountChanged:string, 
  private referenceNumber:string, 
  private formNumber:string, 
  private levelCode:string
){}

  format() {
    return `${this.transactionAmountFormatted} ${this.transactionReasonDescription}\nRef: ${this.referenceNumber}`;
  }

  header() {
    return `${this.payerName} ${this.entryDate}`;
  }
}