export default function ({ $auth, redirect }) {
  if ($auth.user.role != 10) {
    return redirect('/403')
  }
}
