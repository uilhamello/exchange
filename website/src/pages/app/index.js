import React, { Component } from "react";
import { Link, withRouter } from "react-router-dom";

// import Logo from "../../assets/logo.svg";
import api from "../../services/api";
import { login } from "../../services/auth";

import { Form, Container } from "./styles";

class AppExchange extends Component {
  state = {
    currency_from: "",
    currency_to: "",
    value_from: "",
  };

  handleSignIn = async (e) => {
    e.preventDefault();
    const { username, password } = this.state;
    if (!username || !password) {
      this.setState({ error: "Inform your email!" });
    } else {
      try {
        const response = await api.post("/api/login_check", {
          username,
          password,
        });
        login(response.data.token);
        this.props.history.push("/app");
      } catch (err) {
        this.setState({
          error: "Please, check your credential",
        });
      }
    }
  };

  render() {
    return (
      <Container>
        <Form onSubmit={this.handleSignIn}>
          {/* <img src={Logo} alt=" logo" /> */}
          {this.state.error && <p>{this.state.error}</p>}
          <h2>Exchange</h2>
          <input
            type="text"
            placeholder="From"
            onChange={(e) => this.setState({ currency_from: e.target.value })}
          />
          <input
            type="text"
            placeholder="To"
            onChange={(e) => this.setState({ currency_to: e.target.value })}
          />
          <input
            type="text"
            placeholder="Value"
            onChange={(e) => this.setState({ value_from: e.target.value })}
          />
          <button type="submit">Exchange</button>
          <hr />
        </Form>
      </Container>
    );
  }
}

export default withRouter(AppExchange);
