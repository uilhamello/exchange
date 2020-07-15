import React, { Component } from "react";

import { Link, withRouter } from "react-router-dom";

// import Logo from "../../assets/logo.svg";

import { Form, Container } from "./styles";

import api from "../../services/api";

class SignUp extends Component {
  state = {
    username: "",
    password: "",
    error: "",
  };

  handleSignUp = async (e) => {
    e.preventDefault();
    const { username, password } = this.state;
    if (!username || !password) {
      this.setState({ error: "Please fill all fields" });
    } else {
      try {
        await api.post("/register", { username, password });
        this.props.history.push("/");
      } catch (err) {
        console.log(err);
        this.setState({
          error: "Sorry, some error to register your account. T.T",
        });
      }
    }
  };

  render() {
    return (
      <Container>
        <Form onSubmit={this.handleSignUp}>
          {/* <img src={Logo} alt="logo" /> */}
          {this.state.error && <p>{this.state.error}</p>}
          <h2>Sign Up</h2>
          <input
            type="text"
            placeholder="Username"
            onChange={(e) => this.setState({ username: e.target.value })}
          />
          <input
            type="password"
            placeholder="Password"
            onChange={(e) => this.setState({ password: e.target.value })}
          />
          <button type="submit">Register</button>
          <hr />
          <Link to="/">login</Link>
        </Form>
      </Container>
    );
  }
}

export default withRouter(SignUp);
