// localStorage.setItem('meals', JSON.stringify(meals))

let listproduct = document.querySelector('.list-product')
let listtable = document.querySelector('.list-table')
let mealbtn = document.querySelector('.meal-btn')
let tablebtn = document.querySelector('.table-btn')

// mealbtn.addEventListener('click', () => {
//   listproduct.classList.add('display-all')
//   listtable.classList.add('display-non')
// })

// tablebtn.addEventListener('click', () => {
//   listproduct.classList.remove('display-all')
//   listtable.classList.remove('display-non')
// })

let carts = []

let listcart = document.querySelector('.list-cart')
let iconcart = document.querySelector('.icon-cart')
let body = document.querySelector('body')
let closecart = document.querySelector('.close')
let totalitem = document.querySelector('.icon-cart span')

iconcart.addEventListener('click', () => {
  body.classList.toggle('show-cart')
})

closecart.addEventListener('click', () => {
  body.classList.toggle('show-cart')
})

function capitalizeFirstLetter(string) {
  return string.charAt(0).toUpperCase() + string.slice(1)
}
const adddatatohtml = () => {
  if (meals.length >= 1) {
    meals.forEach((item) => {
      console.log('This is origial!')
      let newmeal = document.createElement('div')
      newmeal.classList.add('item')
      newmeal.dataset.id = item.meal_id
      newmeal.innerHTML = `
                <img src="${item.meal_img}" alt="" />
                <h2>${capitalizeFirstLetter(item.meal_name)}</h2>
                <div class="price">$${item.meal_price}</div>
                <button class="add-cart">Add cart</button>`
      listproduct.appendChild(newmeal)
    })
  }
}
adddatatohtml()

listproduct.addEventListener('click', (event) => {
  let positionClick = event.target
  if (positionClick.classList.contains('add-cart')) {
    let meal_id = positionClick.parentElement.dataset.id
    addCard(meal_id)
  }
})

const addCard = (meal_id) => {
  let positionOfThismealInCart = carts.findIndex(
    (value) => value.meal_id == meal_id
  )
  if (carts.length <= 0) {
    carts = [
      {
        meal_id: meal_id,
        quantity: 1,
      },
    ]
    console.log(carts)
  } else if (positionOfThismealInCart < 0) {
    carts.push({
      meal_id: meal_id,
      quantity: 1,
    })
    console.log(carts)
  } else {
    carts[positionOfThismealInCart].quantity =
      carts[positionOfThismealInCart].quantity + 1
    console.log(carts)
  }

  addCardHTML()
  addCardToMemory()
}

const addCardToMemory = () => {
  localStorage.setItem('carts', JSON.stringify(carts))
}

listcart.addEventListener('click', (event) => {
  let positionClick = event.target
  if (
    positionClick.classList.contains('minus') ||
    positionClick.classList.contains('plus')
  ) {
    console.log('work')
    let meal_id = positionClick.parentElement.parentElement.dataset.id
    let type = 'minus'
    if (positionClick.classList.contains('plus')) {
      console.log('change value to plus')
      type = 'plus'
    }
    console.log(type)

    changeQuantity(meal_id, type)
  }
})
const changeQuantity = (meal_id, type) => {
  console.log('Meal id is: ' + meal_id)
  let positionItemCard = carts.findIndex((value) => value.meal_id == meal_id)
  // let info = ;
  console.log(carts[positionItemCard])

  if (type == 'plus') {
    carts[positionItemCard].quantity = carts[positionItemCard].quantity + 1
    // console.log("minus success")
  } else {
    let valchange = (carts[positionItemCard].quantity =
      carts[positionItemCard].quantity - 1)

    if (valchange == 0) {
      carts.splice(positionItemCard, 1)
    } else {
      carts[positionItemCard].quantity = valchange
    }
  }

  addCardToMemory()
  addCardHTML()
}
const initApp = () => {
  if (localStorage.getItem('carts')) {
    console.log('localBD found')
    carts = JSON.parse(localStorage.getItem('carts'))
    addCardHTML()
  }
}

const addCardHTML = () => {
  listcart.innerHTML = ''
  // totalitem.innerHTML = '';
  let totalquantity = 0
  if (carts.length > 0) {
    console.log('local hehe')
    carts.forEach((item) => {
      totalquantity = totalquantity + item.quantity
      let newcart = document.createElement('div')
      let itemposition = meals.findIndex(
        (value) => value.meal_id == item.meal_id
      )
      let info = meals[itemposition]
      newcart.classList.add('list-item')
      newcart.dataset.id = item.meal_id
      newcart.innerHTML = `  <div class="image">
                                            <img src="${
                                              info.meal_img
                                            }" alt="" />
                                        </div>
                                        <div class="name">${
                                          info.meal_name
                                        }</div>
                                        <div class="totalprice">${
                                          info.meal_price * item.quantity
                                        }</div>
                                        <div class="quantity">
                                            <span class="minus">
                                                < </span>
                                                    <span class="">${
                                                      item.quantity
                                                    }</span>
                                                    <span class="plus">></span>
                                        </div>`
      listcart.appendChild(newcart)
    })
  }
  totalitem.innerHTML = totalquantity
}
initApp()

let checkout = document.querySelector('.check-out')

checkout.addEventListener('click', (e) => {
  let positionClick = e.target
  if (positionClick.classList.contains('check-out')) {
    window.location.href = 'checkout.php' // Redirect to checkout page with cart data
  }
})
