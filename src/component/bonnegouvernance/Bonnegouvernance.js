import React from 'react'
import '../index.css'
function Bonnegouvernance() {
    return (
        <div className="container">
        <div className="icon">
         <img src="data:image/jpeg;base64,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"/>
        </div>
        <div className="info">
               <p>Gestion foncière (développement des capacités des services fonciers communaux)  </p>
               <p> Approches et stratégies de décentralisation  </p>
               <p>Approches de développet du secteur de la sécurité   </p>
               <p>Genre et développement (analyse et intégration du genre)</p>
        </div>
    </div>
    )
}

export default Bonnegouvernance
