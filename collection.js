function addToCollectionList(button) {
  const card = button.closest('.product-card');
  const title = card.querySelector('.product-name').textContent;
  const quantity = Number(card.querySelector('.quantity-input').value);
  const list = document.getElementById("collection-list");
  const items = list.getElementsByTagName("li");
  let found = false;

  for (let i = 0; i < items.length; i++) {
    if (items[i].dataset.title === title) {
      let prevQty = Number(items[i].dataset.quantity);
      let newQty = prevQty + quantity;
      items[i].dataset.quantity = newQty;
      items[i].textContent = `${title} | Qty: ${newQty}`;
      found = true;
      break;
    }
  }

  if (!found) {
    const entry = document.createElement("li");
    entry.dataset.title = title;
    entry.dataset.quantity = quantity;
    entry.textContent = `${title} | Qty: ${quantity}`;
    list.appendChild(entry);
  }
}

//remove one element from the collection list

function removeOneFromList() {
  const list = document.getElementById("collection-list");
  const firstEntry = list.querySelector("li");
  if (!firstEntry) return;

  let quantity = Number(firstEntry.dataset.quantity);
  if (quantity > 1) {
    quantity--;
    firstEntry.dataset.quantity = quantity;
    firstEntry.textContent = `${firstEntry.dataset.title} | Qty: ${quantity}`;
  } else {
    list.removeChild(firstEntry);
  }
}

// Same functionnality as the previous fucntion but here we remove each product by itself
function addToCollectionListC(button) {
  const card = button.closest('.product-card');
  const title = card.querySelector('.product-name').textContent;
  const quantity = Number(card.querySelector('.quantity-input').value);
  const list = document.getElementById("collection-list");
  const items = list.getElementsByTagName("li");
  let found = false;

  for (let i = 0; i < items.length; i++) {
    if (items[i].dataset.title === title) {
      let prevQty = Number(items[i].dataset.quantity);
      let newQty = prevQty + quantity;
      items[i].dataset.quantity = newQty;
      items[i].textContent = `${title} | Qty: ${newQty}`;
      // remove button next to each products
      attachRemoveBtn(items[i], list);
      found = true;
      break;
    }
  }

  if (!found) {
    const entry = document.createElement("li");
    entry.dataset.title = title;
    entry.dataset.quantity = quantity;
    entry.textContent = `${title} | Qty: ${quantity}`;
    attachRemoveBtn(entry, list);
    list.appendChild(entry);
  }
}

function attachRemoveBtn(entry, list) {
  let btn = entry.querySelector(".delete-collection-item");
  if (btn) btn.remove();

  btn = document.createElement("button");
  btn.textContent = "Remove";
  btn.className = "delete-collection-item";
  btn.onclick = function() {
    let quantity = Number(entry.dataset.quantity);
    if (quantity > 1) {
      quantity--;
      entry.dataset.quantity = quantity;
      entry.textContent = `${entry.dataset.title} | Qty: ${quantity}`;
      attachRemoveBtn(entry, list);  
    } else {
      list.removeChild(entry);
    }
  };
  entry.appendChild(btn);
}

