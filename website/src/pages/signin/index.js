import React, { Component } from "react";
import { Link, withRouter } from "react-router-dom";

// import Logo from "../../assets/logo.svg";
import api from "../../services/api";
import { login } from "../../services/auth";

import { Form, Container } from "./styles";

class SignIn extends Component {
  state = {
    username: "",
    password: "",
    error: "",
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
          <h2>Login</h2>
          <input
            type="username"
            placeholder="Username"
            onChange={(e) => this.setState({ username: e.target.value })}
          />
          <input
            type="password"
            placeholder="Password"
            onChange={(e) => this.setState({ password: e.target.value })}
          />
          <button type="submit">Login</button>
          <hr />
          <Link to="/signup">Register</Link>
        </Form>
      </Container>
    );
  }
}

export default withRouter(SignIn);
