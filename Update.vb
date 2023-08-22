
    Private Sub Button4_Click(sender As Object, e As EventArgs) Handles Button4.Click
        If (Texta.Text = "" Or TextBox2.Text = "" Or ComboBox1.Text = "" Or ComboBox2.Text = "") Then
            MsgBox("Data Tidak boleh kosong")
            Exit Sub
        End If
        connection.Open()
        Dim updt As New MySqlCommand("Update Hnilai SET matap = '" & ComboBox2.Text & "',absen = '" & Texta.Text & "',latihan = '" & Textl.Text & "',kuis = '" & Textk.Text & "',uts = '" & Textua.Text & "', uas = '" & Textua.Text & "' where nis = '" & ComboBox1.Text & "' and nama = '" & TextBox2.Text & "' ", connection)
        Dim readerw As MySqlDataReader = updt.ExecuteReader()
        MsgBox("Data berhasil di update")
        Dim sel As New MySqlCommand("Select * from Hnilai", connection)
        ' Menghapus semua item dari ListView dengan nama "ListView1"
        bersih()
        ListView1.Items.Clear()
        connection.Close()
        dataterakhir(sel)
    End Sub
End Class
