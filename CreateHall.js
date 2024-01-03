import { BackgroundImage, Container } from "@mantine/core";
import React, { useState } from "react";
import {
  MantineProvider,
  Paper,
  TextInput,
  NumberInput,
  Select,
  Button,
  Modal,
  Input,
  Tooltip,
  Popover,
} from "@mantine/core";
import styles from "./CreateHall.module.css";

const CreateHall = () => {
  const [seats, setSeats] = useState("");
  const [columns, setColumns] = useState("");
  const [rows, setRows] = useState("");
  const [hallId, setHallId] = useState("");
  const [newType, setNewType] = useState("");
  const [price, setPrice] = useState("");
  const [types, setTypes] = useState([
    { value: "New", label: "Add new type" },
    { value: "Standard", label: "Standard" },
    { value: "3D", label: "3D" },
  ]);
  const [selectedType, setSelectedType] = useState("");

  const [isNewTypeModalOpen, setIsNewTypeModalOpen] = useState(false);
  const updateData = (newType) => {
    // Define what happens when the function is called
    console.log(newType);
  };
  const [generatedSeats, setGeneratedSeats] = useState([]);
  const [selectedSeats, setSelectedSeats] = useState([]);

  const generateSeats = () => {
    const seats = [];
    for (let rowIndex = 0; rowIndex < parseInt(rows); rowIndex++) {
      const row = [];
      for (
        let columnsIndex = 0;
        columnsIndex < parseInt(columns);
        columnsIndex++
      ) {
        const seat = {
          id: rowIndex * parseInt(columns) + columnsIndex + 1,
          number: "",
          available: true,
        };
        row.push(seat);
      }
      seats.push(row);
    }
    setGeneratedSeats(seats);
  };

  const handleSeatClick = (rowIndex, columnsIndex) => {
    console.log("Seat clicked:", rowIndex, columnsIndex);

    const selectedSeatId = rowIndex * parseInt(columns, 10) + columnsIndex + 1;
    // Toggle seat selection
    setSelectedSeats((prevSelectedSeats) => {
      const updatedSelectedSeats = prevSelectedSeats.includes(selectedSeatId)
        ? prevSelectedSeats.filter((seatId) => seatId !== selectedSeatId)
        : [...prevSelectedSeats, selectedSeatId];

      console.log("Selected Seats:", updatedSelectedSeats);

      return updatedSelectedSeats;
    });

    // Toggle seat availability
    setGeneratedSeats((prevGeneraredSeats) => {
      const updatedGeneratedSeats = prevGeneraredSeats.map((row, rIndex) =>
        rIndex === rowIndex
          ? row.map((seat, cIndex) =>
              cIndex === columnsIndex
                ? { ...seat, available: !seat.available }
                : seat
            )
          : row
      );

      console.log("Generated Seats:", updatedGeneratedSeats);

      return updatedGeneratedSeats;
    });
  };

  const handleCreatHall = (event) => {
    event.preventDefault();
    generateSeats();
  };
  const handleNewTypeSubmission = (newType) => {
    updateData(newType);
    setTypes([...types, { value: newType, label: newType }]);
    setPrice({ value: price, label: "set seat's price" });
    setIsNewTypeModalOpen(false);
  };
  const handleSaveChanges = () => {
    //send generatedSeats data to back
    console.log("Saving changes...");
    //close the seat chart
    setGeneratedSeats([]);
    setSeats("");
    setColumns("");
    setRows("");
    setSelectedSeats([]);
  };

  return (
    <MantineProvider>
      <h2 order={1} align="left">
        Create New Hall:
      </h2>

      <div className={styles["horizontal-line"]}>
        <Container className={`${styles.container} ${styles["vertical-line"]}`}>
          <TextInput
            label="Number of Seats"
            type="number"
            value={seats}
            onChange={(e) => setSeats(e.target.value)}
          />
          <TextInput
            label="Columns"
            type="number"
            value={columns}
            onChange={(e) => setColumns(e.target.value)}
          />
          <TextInput
            label="Rows"
            type="number"
            value={rows}
            onChange={(e) => setRows(e.target.value)}
          />
          <Select
            label="Type"
            value={selectedType}
            onChange={(value) => {
              setSelectedType(value);
              if (value === "New") {
                setIsNewTypeModalOpen(true);
              }
            }}
            data={types}
          />

          <TextInput
            label="Hall ID"
            type="number"
            value={hallId}
            onChange={(e) => setHallId(e.target.value)}
          />
          <Button
            type="submit"
            size="md"
            variant="gradient"
            gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
            style={{ marginTop: 20 }}
            onClick={handleCreatHall}
          >
            Create Hall
          </Button>
        </Container>
      </div>

      {generatedSeats.length > 0 && (
        <div>
          <h3>Hall:{hallId}</h3>
          <Paper shadow="sm" className={styles["seat-container"]}>
            {generatedSeats.map((row, rowIndex) => (
              <div key={rowIndex} className={styles.row}>
                {row.map((seat, columnsIndex) => (
                  <Tooltip
                    key={seat.id}
                    label={`${
                      selectedType === "3D" ? "Price:$15 " : "Price:$10 "
                    }`}
                  >
                    <div
                      key={seat.id}
                      className={`${styles.seat} ${
                        !seat.available ? styles.unavailable : ""
                      }`}
                      on
                      onClick={() => handleSeatClick(rowIndex, columnsIndex)}
                    >
                      {seat.number}
                    </div>
                  </Tooltip>
                ))}
              </div>
            ))}
            <div>
              <Button onClick={handleSaveChanges}>Done</Button>
            </div>
          </Paper>
        </div>
      )}
      {isNewTypeModalOpen && (
        <Modal
          opened={isNewTypeModalOpen}
          onClose={() => setIsNewTypeModalOpen(false)}
          title="Add New Type"
        >
          <Input
            label="New Type"
            placeholder="add new hall type"
            value={newType}
            onChange={(e) => setNewType(e.target.value)}
          />
          <Input
            label="Price for each seat"
            placeholder="Enter the price"
            value={price}
            onChange={(e) => setPrice(e.target.value)}
          />
          <Button
            variant="gradient"
            gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 102 }}
            onClick={() => handleNewTypeSubmission(newType)}
            placeholder="Add the new Type of hall"
          >
            Submit
          </Button>
        </Modal>
      )}
    </MantineProvider>
  );
};
export default CreateHall;
