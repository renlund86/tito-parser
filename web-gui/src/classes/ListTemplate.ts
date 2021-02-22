import { HasFormatter } from "../interfaces/HasFormatter";

export class ListTemplate {
  constructor(private container: HTMLUListElement){}

  render(item: HasFormatter, pos: 'start' | 'end'){
    const li = document.createElement('li');
    li.setAttribute("class", "list-item");
    const h4 = document.createElement('h4');
    h4.innerText = item.header();
    li.append(h4);

    const p = document.createElement('p');
    p.innerText = item.format();
    li.append(p);

    if(pos === 'start'){
      this.container.prepend(li);
    } else {
      this.container.append(li);
    }
  }

  clearList() {
    let listItems = document.querySelectorAll('.list-item') as NodeListOf<HTMLUListElement>;

    if(listItems.length > 0) {
      listItems.forEach((element:any, index:any) => {
        element.remove();
      });
    }
  }
}