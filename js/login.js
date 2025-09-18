function parseJwt(token) {
  let base64Url = token.split('.')[1];
  let base64 = base64Url.replace(/-/g, '+').replace(/_/g, '/');
  let jsonPayload = decodeURIComponent(window.atob(base64).split('').map(function(c) {
      return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
  }).join(''));
  return JSON.parse(jsonPayload);
}

function handleCredentialResponse(response) {
  const data = parseJwt(response.credential);

  // Send email to PHP to check or auto-register
  fetch("google_login.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      email: data.email,
      name: data.name
    })
  })
  .then(res => res.json())
  .then(result => {
    if (result.success) {
      window.location.href = result.redirect;
    } else {
      alert("Google login failed!");
    }
  });
}
