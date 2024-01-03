import React, { useState } from "react";
import {
  Card,
  Image,
  Text,
  Badge,
  Button,
  Group,
  InputWrapper,
} from "@mantine/core";
import styles from "./OfferType.module.css";
import { useDisclosure } from "@mantine/hooks";
import { Modal } from "@mantine/core";
import ShowOffer from "./ShowOffer";
import SnackOffer from "./SnackOffer";

const OfferType = () => {
  return (
    <div style={{ display: "flex" }}>
      <ShowOffer /> <SnackOffer />
    </div>
  );
};
export default OfferType;
