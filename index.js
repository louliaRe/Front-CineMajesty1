import React from "react";
import "@mantine/core/styles.css";
import ReactDOM from "react-dom";
import { BadgeCard } from "./Admin/BadgeCard";
import { Center, MantineProvider, createTheme } from "@mantine/core";
import DoubleNavbar from "./Admin/DoubleNavebar";
import EmployeesTable from "./Admin/EmployeesTable";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import EmployeesPage from "./Admin/EmployeesPage";
import EmpServices from "./Employee/EmpServices";
import EmpNavbar from "./Employee/EmpNavbsr";
import Snack from "./Employee/Snack";
import FillPocket from "./Employee/FillPocket";
import "@mantine/carousel/styles.css";
import AddMovie from "./Employee/AddMovie";
import CreateHall from "./component/CreateHall";
import MovieSchedule from "./component/MovieSchedule";
import EmpTR from "./Admin/EmpTR";
import BookingSeats from "./component/Customer/BookingSeats";
import OfferType from "./component/OfferType";

const App = () => {
  return (
    <MantineProvider>
      <Router>
        <div
          style={{
            display: "flex",
            flexDirection: "row",
            alignContent: "center",
          }}
        >
          {/* <DoubleNavbar />  */}

          <EmpNavbar />

          <div
            style={{
              flex: 1,
              display: "flex",
              justifyContent: "center", // Center align the content horizontally
              alignItems: "center", // Center align the content vertically
              marginLeft: "20px", // Adjust the left margin
              marginRight: "20px",
            }}
          >
            <Routes>
              {/* <Route path="/" element={<BookingSeats />} /> */}
              {/* <Route path="/" element={<EmpServices />} /> */}
              <Route path="/path/to/FillPocket" element={<FillPocket />} />
              <Route path="/path/to/snack" element={<Snack />} />

              <Route path="Employee/OfferType" element={<OfferType />} />

              <Route path="path/to/AddMovie" element={<AddMovie />} />
              <Route path="path/to/MovieSchedule" element={<MovieSchedule />} />
              <Route path="path/to/CreateHall" element={<CreateHall />} />
              {/* // <Route path="/employees-list" element={<EmployeesPage />} /> */}

              <Route path="/Admin/Emptable" element={<EmpTR />} />
            </Routes>
          </div>
        </div>
      </Router>
    </MantineProvider>
  );
};

ReactDOM.render(<App />, document.querySelector("#root"));
