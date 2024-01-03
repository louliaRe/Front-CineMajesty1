import { Grid } from "@mantine/core";
import "./Snack.module.css";
import { Link } from "react-router-dom";

function Snack() {
  return (
    <Grid grow gutter="lg">
      <Grid.Col span={4}>
        <Link>
          <div className="image-container">
            <div className="overlay-content"></div>
            <img
              src="/img/Drinks.jpg"
              alt="Drinks"
              height="200"
              width="200"
            ></img>
          </div>
        </Link>
      </Grid.Col>

      <Grid.Col span={4}>
        <Link to="/path/to/popcorn">
          <div className="image-container">
            <img
              src="/img/Popcorn.jpg"
              alt="popcorn"
              height="200"
              width="200"
            ></img>
          </div>
        </Link>
      </Grid.Col>

      <Grid.Col span={4}>
        <div className="image-container">
          <img src="/img/f2.png" alt="Burger" height="200" width="200"></img>
        </div>
      </Grid.Col>

      <Grid.Col span={6}>
        <div className="image-container">
          <img src="/img/Pizza.png" alt="Pizza" height="200" width="200"></img>
        </div>
      </Grid.Col>

      <Grid.Col span={6}>
        <div className="image-container"></div>

        <svg
          xmlns="http://www.w3.org/2000/svg"
          viewBox="0 0 32 32"
          height="200"
          width="200"
          style={{
            transition: "transform 0.3s",
            color: "inherit",
            opacity: "1",
            zIndex: "1",
            boxShadow: "0 0 20px 10px slategrey",
            borderRadius: "10px 10px 10px 10px",
          }}
        >
          <g data-name="88-Option Add">
            <path d="M29 4h-3V3a3 3 0 0 0-3-3H3a3 3 0 0 0-3 3v20a3 3 0 0 0 3 3h1v3a3 3 0 0 0 3 3h22a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zM4 7v17H3a1 1 0 0 1-1-1V3a1 1 0 0 1 1-1h20a1 1 0 0 1 1 1v1H7a3 3 0 0 0-3 3zm26 22a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h22a1 1 0 0 1 1 1z" />
            <path d="M19 11h-2v6h-6v2h6v6h2v-6h6v-2h-6v-6z" />
          </g>
        </svg>
      </Grid.Col>
    </Grid>
  );
}
export default Snack;
