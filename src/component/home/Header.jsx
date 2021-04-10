import React from "react";
import { useHistory, useLocation, Link } from "react-router-dom";
import Logo from "../../images/logo.png";

function Header() {
    const history = useHistory();
    const location = useLocation();

    return (
        <div className="header">
            <img src={Logo} alt="logo" onClick={() => history.push("/")} />
            {location.pathname === "/" ? (
                <div className="header__menu">
                    <a href="#about">A PROPOS</a>
                    <a href="#whatWeBelieve">CE QUE NOUS CROYONS</a>
                    <a href="#expertise">EXPERTISE</a>
                    <a href="#contact">CONTACT</a>
                </div>
            ) : (
                <div className="header__menu">
                    <Link to="/">ACCEUIL</Link>
                </div>
            )}
            <div className="mobile_header_menu">
                <a href="#about">A PROPOS</a>
                <a href="#whatWeBelieve">CE QUE NOUS CROYONS</a>
                <a href="#expertise">EXPERTISE</a>
                <a href="#contact">CONTACT</a>
            </div>
        </div>
    );
}

export default Header;
