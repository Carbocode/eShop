import Header from "./Header.js"

function ImgHeader(){
    return(
        <div class="header__image">
            <div class="header__image__text">BUY YOUR CUBE</div>
        </div>
    )
}

function Products(){
    return(
        <div>
            <h1 style="font-size: 45px; margin: 20px">Products</h1>
            <div class="store">
            </div>
        </div>
    )
}

function Footer(){
    return(
        <div class="footer">
            <form method="POST">
                <input type="submit" name="DeleteCookie" value="Cancella Cookie" />
            </form>
        </div>
    )
}

function Page(){
    return (
        <div>
            <Header/>
            <ImgHeader/>
            <Products />
            <Footer/>
        </div>
    )
}

ReactDOM.render(<ImgHeader />,document.getElementById("root"))