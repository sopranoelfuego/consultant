import React, { useState } from "react";

function Home() {
    const [expand, setExpand] = useState(false);

    return (
        <div>
            {/* INTRO */}
            <div
                className="intro"
                id=""
                style={{
                    backgroundImage: "url(/images/pexels-pixabay-209224.jpg)",
                    backgroundPosition: "center",
                    backgroundSize: "cover",
                    minHeight: "90vh",
                    display: "flex",
                    justifyContent: "center",
                    alignItems: "center",
                }}>
                <div className="intro__info">
                    <h2>GD Experts</h2>
                    <p>Cabinet conseils en gouvernance et développement.</p>
                </div>
            </div>
            {/* END OF INTRO */}
            {/* WHO ARE WE */}
            <div className="whoWeAre" id="about">
                <div
                    className="whoWeAre__info"
                    data-aos="fade-right"
                    data-aos-duration="1000">
                    <h2>Qui sommes-nous ?</h2>
                    <div>
                        <p>
                            GD-experts est un cabinet conseil qui apporte son expertise aux
                            institutions publiques et privées dans le domaine de Gouvernance
                            et développement.
                        </p>
                        <p style={{ display: expand ? "block" : "none" }}>
                            GD Experts groupe des praticiens expérimentés de la conception et
                            de la mise en œuvre des projets et programmes de coopération au
                            développement de l’Afrique centrale et orientale avec les
                            partenaires bilatéraux et multilatéraux tels que l’Union
                            Européenne et ses pays membres, l’USAID, le PNUD et les autres
                            agences du système des Nations Unies, la Banque Mondiale et la
                            Banque Africaine de Développement.
                        </p>
                    </div>
                    <button className="link" onClick={() => setExpand(!expand)}>
                        {expand ? "minimise.." : "plus.."}
                    </button>
                </div>
                <img
                    src="/images/undraw_Success_factors_re_ce93.svg"
                    alt="kidegage"
                    data-aos="fade-left"
                    data-aos-duration="1000"
                />
            </div>

            {/* END OF WHO WE ARE */}
            {/* WHAT WE THINK */}
            <div className="whatWeThink" id="whatWeBelieve">
                <img
                    src="/images/undraw_Project_completed_re_pqqq (1).svg"
                    alt="mbega"
                    data-aos="fade-right"
                    data-aos-duration="1000"
                />
                <div
                    className="whatWeThink__info"
                    data-aos="fade-left"
                    data-aos-duration="1000">
                    <h2>Ce que nous croyons ?</h2>
                    <p>
                        Nous réalisons notre plus grand impact sociétal en collaboration avec
                        nos clients. Nous sommes profondément engagés à faire une différence
                        en aidant les communautés à s’epanouir en donnant la priorité à notre
                        impact social.
                    </p>
                    <a href="#savoir" className="link">
                        En savoir plus
                    </a>
                </div>
            </div>
            {/* END OF WHAT WE THINK 
                   developpement"
gestionprojets
reintegration" */}
            {/* EXPERTISE */}
            <div className="expertise" id="expertise">
                <div className="expertise__info" data-aos="fade-up" data-aos-duration="1000">
                    <h2>Expertise</h2>
                    <h3>Avec autant d'années d'experience dans de ces domaines</h3>
                    <p>
                        La bonne gouvernance est synonyme de transparence, de participation,
                        de responsabilité et de respect du droit
                    </p>
                </div>
                <img
                    src="/images/undraw_certificate_343v.svg"
                    alt=""
                    data-aos="fade-up"
                    data-aos-duration="1000"
                />
            </div>
            {/* END OF EXPERTISE */}
            {/* EXPERTISE DOMAINS */}
            <div className="container__expertiseOptions">
                <div
                    style={{ textAlign: "center", width: "100%", justifyContent: "center" }}>
                    <h2>Domaines d'expertise</h2>
                </div>

                <div className="expertiseOptions">
                    <a className="option" href="/developpement">
                        <i className="fas fa-people-carry" />
                        <h5>Développement local</h5>
                    </a>
                    <a className="option" href="/gestionprojets">
                        <i className="fas fa-tasks" />
                        <h5>Gestion des project</h5>
                    </a>
                    <a className="option" href="/Bonnegouvernance">
                        <i className="fas fa-people-arrows" />
                        <h5>Bonne gouvernance</h5>
                    </a>
                    <a className="option" href="/reintegration">
                        <i className="fas fa-hand-holding-usd" />
                        <h5>Réintégration socio-économique</h5>
                    </a>
                </div>
            </div>
            {/* END OF DOMAINS EXPERTISE */}
            {/* LOCATION */}
            <div className="location" id="contact">
                <iframe
                    src="https://www.google.com/maps/d/u/0/embed?mid=1DbyMWEXQT1zLFh7kK2u4kUajlX1NrZiV"
                    width="600"
                    height="450"
                    style={{ border: "0" }}
                    allowFullScreen=""
                    loading="lazy"
                    title="location"
                />

                <div className="location__info" data-aos="zoom-in" data-aos-duration="1000">
                    <h2>Location</h2>
                    <p>
                        Bujumbura, BURUNDI,Boulevard de l'independance,Peace House, 1er
                        étage, numéro 19
                    </p>
                    <h2>Contactez nous</h2>
                    <p>
                        Phone:(+257) 79 955 747 <br />
                        info@gd-experts.org
                    </p>
                </div>

                {/* END OF LOCTION */}
            </div>
        </div>
    );
}

export default Home;
