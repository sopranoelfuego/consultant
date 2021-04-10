import React from "react";
import { Switch, Route } from "react-router-dom";
import AOS from "aos";
import Home from "./component/home/Home";
import "./App.css";
import Developpement from "./component/developpement/Developpment";
import GestionProjets from "./component/gestionProjects/GestionProjets";
import Reintegration from "./component/reintegration/Reintegration";
import Bonnegouvernance from "./component/bonnegouvernance/Bonnegouvernance";
import Header from "./component/home/Header";
import Footer from "./component/home/Footer";

import "aos/dist/aos.css"; // You can also use <link> for styles
// ..
AOS.init();
const App = () => {
    return (
        <div className="App">
            <Header />
            <Switch>
                <Route exact path="/" component={Home} />
                <Route path="/developpement" component={Developpement} />
                <Route path="/gestionprojets" component={GestionProjets} />
                <Route path="/reintegration" component={Reintegration} />
                <Route path="/bonnegouvernance" component={Bonnegouvernance} />
            </Switch>
            <Footer />
        </div>
    );
};

export default App;
