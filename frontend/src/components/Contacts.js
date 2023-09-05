import {useParams} from "react-router-dom";

function Contacts() {
    const params=useParams();
    const number=params.number;
    return(
        <div>
            <h1>Contacts Page</h1>
        </div>
    );
}
export default Contacts;