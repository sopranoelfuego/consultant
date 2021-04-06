import React, { Component } from 'react'
import {useHistory,useLocation,Link} from "react-router-dom"
 
 function Header (){
    let history=useHistory()
    let location=useLocation()
    
        return (

             <div className="header">
             <img src="/images/logo.png" alt="logo" onClick={()=>history.push('/')}/>
             {location.pathname === '/'? (
                 <div className="header__menu">
                    <a href="#about">A PROPOS</a>
                    <a href="#whatWeThink">CE QUE NOUS CROYONS</a>
                    <a href="#expertise">EXPERTISE</a>
                    <a href="#contact">CONTACT</a>
                </div>
             ):(
                <div className="header__menu">
                    <Link to="/">ACCEUIL</Link>

            </div>
             )}

             </div>

        )
    
}


export default Header