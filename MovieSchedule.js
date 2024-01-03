import { extend } from "dayjs";
import React, { useState } from "react";
import Classes from "./MovieSchedule.module.css";
import button from "@mantine/core/styles/Button.css";
import { useDisclosure } from "@mantine/hooks";
import { Modal, Button } from "@mantine/core";

const EditModal = ({ day, slot, onClose, onSave }) => {
  const [available, setAvailable] = useState(!slot.MovieName && slot.available);
  const [movieName, setMovieName] = useState(slot.MovieName || "");

  const handleSave = () => {
    onSave(day, slot, movieName);
    onClose();
  };
};

const MovieSchedule = () => {
  const [schedule, setSchedule] = useState([
    {
      day: "Friday",
      slots: [
        { time: "11:00 => 14:00", hallId: 3, MovieName: "batman" },
        { time: "14:00 => 17:00", hallId: 5, MovieName: "Spider man" },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: true },
      ],
    },
    {
      day: "Saturday",
      slots: [
        { time: "11:00 => 14:00", available: true },
        { time: "14:00 => 17:00", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false },
      ],
    },
    {
      day: "Sunday",
      slots: [
        { time: "11:00 => 14:00", available: true },
        { time: "14:00 => 17:00", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false },
      ],
    },
    {
      day: "Monday",
      slots: [
        { time: "11:00 => 14:00", available: true },
        { time: "14:00 => 17:00", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false },
      ],
    },
    {
      day: "Tuesday",
      slots: [
        { time: "11:00AM, => 14:00PM", available: true },
        { time: "14:00 AM=> 17:00 PM", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false, MovieName: "Barbie" },
      ],
    },
    {
      day: "Wedensday",
      slots: [
        { time: "11:00 => 14:00", available: true },
        { time: "14:00 => 17:00", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false },
      ],
    },
    {
      day: "Thuresday",
      slots: [
        { time: "11:00 => 14:00", available: true },
        { time: "14:00 => 17:00", available: false },
        { time: "17:00 => 20:00", available: true },
        { time: "20:00 => 23:00", available: false },
      ],
    },
    // ...
  ]);

  // Update the schedule data

  const [opened, setOpened] = useState(false);
  const [movieName, setMovieName] = useState("");
  const [available, setAvailable] = useState(false);
  const [editDay, setEditDay] = useState(null);
  const [editSlotIndex, setEditSlotIndex] = useState(null);
  const [hallId, setHallId] = useState(" ");

  const handleEdit = (dayIndex, slotIndex) => {
    setEditDay(dayIndex);
    setEditSlotIndex(slotIndex);
    const day = schedule[dayIndex];
    const slot = day.slots[slotIndex];
    setMovieName(slot.MovieName || "");
    setAvailable(slot.available || false);
    setOpened(true);
  };

  const handleClose = () => {
    setOpened(false);
    setEditDay(null);
    setEditSlotIndex(null);
    setMovieName("");
    setAvailable(false);
  };
  const handleSave = () => {
    if (editDay !== null && editSlotIndex !== null) {
      setSchedule((prevSchedule) => {
        const newSchedule = [...prevSchedule];
        const editedDay = { ...newSchedule[editDay] };
        const editedSlot = {
          ...editedDay.slots[editSlotIndex],
          MovieName: movieName,
          available: available,
          hallId: hallId,
        };

        editedDay.slots[editSlotIndex] = editedSlot;
        newSchedule[editDay] = editedDay;
        return newSchedule;
      });
      setOpened(false);
      setEditDay(null);
      setEditSlotIndex(null);
      setMovieName("");
      setAvailable(false);
    }
  };

  return (
    <div className="center">
      <table className="movie-schedule">
        <thead>
          <tr>
            <th>Day</th>
            {schedule[0].slots.map((slot, index) => (
              <th key={index}>{slot.time}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {schedule.map((day, dayIndex) => (
            <tr key={dayIndex}>
              <th>{day.day}</th>
              {day.slots.map((slot, slotIndex) => (
                <td
                  key={slotIndex}
                  style={{
                    backgroundColor: slot.MovieName ? "red" : "white",
                  }}
                  onClick={() => handleEdit(dayIndex, slotIndex)}
                >
                  {slot.MovieName}
                  <br />

                  {slot.hallId}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
      {opened && (
        <Modal
          opened={opened}
          onClose={handleClose}
          onSave={handleSave}
          centered
          styles={{ modal: { maxWidth: "500px", margin: "auto" } }}
        >
          <form>
            <label htmlFor="movieName">Movie Name:</label>
            <input
              id="movieName"
              type="text"
              value={movieName}
              onChange={(e) => setMovieName(e.target.value)}
              style={{ width: "100%", padding: "10px", marginBottom: "10px" }}
            />

            <label htmlFor="HallId">Hall id:</label>
            <input
              id="HallId"
              type="Text"
              value={hallId}
              onChange={(e) => setHallId(e.target.value)}
              required
              style={{ width: "100%", padding: "10px", marginBottom: "10px" }}
            />

            <Button
              onClick={handleSave}
              size="md"
              radius="xl"
              variant="gradient"
              gradient={{ from: "rgba(0, 0, 0, 1)", to: "pink", deg: 98 }}
              style={{ width: "100%" }}
            >
              Save
            </Button>
          </form>
        </Modal>
      )}
    </div>
  );
};
export default MovieSchedule;
