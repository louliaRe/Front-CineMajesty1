import React, { useState } from "react";
import { MantineProvider, Paper, Tooltip, Button } from "@mantine/core";
import styles from "./BookingSeats.module.css";

const BookSeats = ({ generatedSeats, onSeatSelect }) => {
  const [selectedSeats, setSelectedSeats] = useState([]);

  const handleSeatClick = (rowIndex, seatNumber) => {
    // Assuming you want to allow selecting/deselecting seats
    setSelectedSeats((prevSelectedSeats) => {
      const seatId = rowIndex * generatedSeats[0].length + seatNumber;
      return prevSelectedSeats.includes(seatId)
        ? prevSelectedSeats.filter((id) => id !== seatId)
        : [...prevSelectedSeats, seatId];
    });
  };

  const isSeatSelected = (rowIndex, seatNumber) => {
    const seatId = rowIndex * generatedSeats[0].length + seatNumber;
    return selectedSeats.includes(seatId);
  };
  if (!generatedSeats || !generatedSeats.length) {
    return <div>No seats data available</div>;
  }

  return (
    <MantineProvider>
      <div>
        <h3>Choose Your Seats:</h3>
        <Paper shadow="sm" className={styles["seat-container"]}>
          {generatedSeats.map((row, rowIndex) => (
            <div key={rowIndex} className={styles.row}>
              {row.map((seat) => (
                <Tooltip key={seat.id} label={`${seat.number}`}>
                  <div
                    key={seat.id}
                    className={`${styles.seat} ${
                      !seat.available
                        ? styles.unavailable
                        : isSeatSelected(rowIndex, seat.number)
                        ? styles.selected
                        : ""
                    }`}
                    onClick={() => {
                      if (seat.available) {
                        handleSeatClick(rowIndex, seat.number);
                      }
                    }}
                  >
                    {seat.number}
                  </div>
                </Tooltip>
              ))}
            </div>
          ))}
          <div>
            <Button onClick={() => onSeatSelect(selectedSeats)}>
              Book Selected Seats
            </Button>
          </div>
        </Paper>
      </div>
    </MantineProvider>
  );
};

export default BookSeats;
