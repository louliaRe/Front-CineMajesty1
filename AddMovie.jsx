import React, { useState } from "react";
import {
 Input,
 Button,
 MultiSelect,
 Container,
 Group,
 Title,
 Slider,
 Select,
 Card,
 FileInput,
Box,
 Modal,
} from "@mantine/core";
import { DateInput } from '@mantine/dates';
import { Link } from "react-router-dom";
import styles from './AddMovie.module.css';
const AddMovie = () => {
  const [filmInfo, setFilmInfo] = useState({
    movieName: "",
    movieDescription: "",
    types: [],
    ageRequire: "",
    actors: [],
    newActor: "",
    startDate: null,
    endDate: null,
    duration:"",
   });
   const [opened, setOpened] = useState(false);
   const [firstName, setFirstName] = useState('');
   const [lastName, setLastName] = useState('');
   const [role, setRole] = useState('');
  
   const openModal = () => setOpened(true);
   const closeModal = () => setOpened(false);
  

 const handleInputChange = (field, value) => {
   setFilmInfo((prevInfo) => ({ ...prevInfo, [field]: value }));
 };

 const handleUploadFilm = () => {
   console.log("Film information:", filmInfo);
 };

 const handleNewActorAddition = () => {
   if (
     Array.isArray(filmInfo.actors) &&
     filmInfo.actors.every((actor) => typeof actor === 'object' && 'label' in actor) &&
     typeof filmInfo.newActor === "string" &&
     filmInfo.newActor.trim() !== ""
   ) {
     setFilmInfo((prevInfo) => ({
       ...prevInfo,
       actors: [
         ...prevInfo.actors.map(actor => actor.label),
         { value: filmInfo.newActor, label: filmInfo.newActor },
       ],
       newActor: "",
     }));
   }
 };

 return (
  <>
     <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', justifyContent: 'flex-start' }}>
   <Title order={2} align="left" orderMd={1} style={{ marginBottom: '20px' ,marginTop:'20px' }}>
     Add New Movie :
   </Title>

   <Box padding="md" className={styles.container} style={{ marginTop: "60px", marginLeft:"150px" ,borderRadius: "8px"  }}>
     

  
       
       <Input.Wrapper label="Movie Name" id="movieName" className={styles.inputField}>
       <Input
         id="movieName"
         value={filmInfo.movieName}
         onChange={(e) => handleInputChange("movieName", e.target.value)}
       />
     
       
     </Input.Wrapper>
     

    
     <Input.Wrapper label="Movie Description" id="movieDescription" className={styles.inputField}>
       <Input
         id="movieDescription"
         value={filmInfo.movieDescription}
         onChange={(e) => handleInputChange("movieDescription", e.target.value)}
       />
     </Input.Wrapper>


 
         <MultiSelect
           data={[
             { value: "horror", label: "Horror" },
             { value: "adventure", label: "Adventure" },
             {value : "action ", label: "Action"},
             {value : "darma", label: "Drama"},
             {value:"comedy", label:"Comedy"},
             {value:"crime", label:"Crime"},
             {value:"animation", label:"Animation"},
             {value:"war", label:"War"},
             {value:"history", label:"History"},
             {value:"musical", label:"Musical"},
             {value:"mystery", label:"Mystery"},

           ]}
           value={filmInfo.types}
           onChange={(selected) => handleInputChange("types", selected)}
           label="Selected Film Types"
           className={styles.inputField}
         />
       
    
       <Input.Wrapper label="Age Required" id="ageRequired" className={styles.inputField}>
       <Input
         id="movieDescription"
         value={filmInfo.ageRequire}
         onChange={(e) => handleInputChange("ageRequired", e.target.value)}
       />
     </Input.Wrapper>
       

      
      
        <div >

     <MultiSelect
     className={styles.inputField}
       data={filmInfo.actors}
       value={filmInfo.actors}
       onChange={(selected) => handleInputChange("actors", selected)}
       label="Select Actors"  
     />

     <Button onClick={openModal}
       radius={"lg"}
       size="sm"
       variant="gradient"
       gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}>
       Add Actor
     </Button>
           
 </div>


       
         <Input.Wrapper label=" Movie's Poster:" id="poster" className={styles.inputField}>
      <FileInput
        id="poster"
        placeholder="Upload the Poster"
        multiple
        onChange={(e) => handleInputChange("poster", e.target.files)}
      />
    </Input.Wrapper>

    <Input.Wrapper label="Movie's Trailer" id="trailer" className={styles.inputField}>
      <FileInput
        id="trailer"
        placeholder="Upload trailer:"
        multiple
        onChange={(e) => handleInputChange("trailer", e.target.files)}
      />
    </Input.Wrapper>

<Input.Wrapper label="Duration" id="duration"className={styles.inputField}>
    <Input
    id="duration"
      placeholder="Enter movie duration"
     value={filmInfo.duration}
       onChange={(e) => handleInputChange("duration", e.target.value)}
        />
        </Input.Wrapper>


    <Group spacing="sm">
 <DateInput
  label="Start Date"
  placeholder="Enter start date"
  value={filmInfo.startDate}
  onChange={(value) => handleInputChange("startDate", value)}
 />
 <DateInput
  label="End Date"
  placeholder="Enter end date"
  value={filmInfo.endDate}
  onChange={(value) => handleInputChange("endDate", value)}
 />
</Group>





       <Button
         onClick={handleUploadFilm}
         size="md"
         variant="gradient"
         gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
         style={{ marginTop: 20 }}
         fullWidth
       >
         Submit
       </Button>

       </Box>
       <div>
 <Link to="/path/to/MovieSchedule">
   <h4>Take a look of the schedule of showTimes</h4> 
   </Link>
 </div>

<Modal opened={opened} onClose={closeModal} title="Add New cast" centered>
 <Input label="First Name" value={firstName} onChange={setFirstName} />
 <Input label="Last Name" value={lastName} onChange={setLastName} />
 <Select label="Role" value={role} onChange={setRole}>
   <option value="director">Director</option>
   <option value="actor">Actor</option>
   <option value="both">Both</option>
   <option value="other">Other</option>
 </Select>
 <Button onClick={handleNewActorAddition }>Add Cast</Button>
</Modal>
</div>
</>
  );
};
export default AddMovie;
