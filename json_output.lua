done = function(summary, latency, requests)
  io.write("{\n")
  io.write(string.format("  \"requests\": %d,\n", summary.requests))
  io.write(string.format("  \"duration_in_microseconds\": %d,\n", summary.duration))
  io.write(string.format("  \"bytes\": %d,\n", summary.bytes))
  io.write(string.format("  \"requests_per_sec\": %.2f,\n", summary.requests/(summary.duration/1000000)))
  io.write(string.format("  \"bytes_transfer_per_sec\": %.2f,\n", summary.bytes/(summary.duration/1000000)))
  io.write(string.format("  \"latency_min\": %.2f,\n", latency.min))
  io.write(string.format("  \"latency_max\": %.2f,\n", latency.max))
  io.write(string.format("  \"latency_mean\": %.2f,\n", latency.mean))
  io.write(string.format("  \"latency_stdev\": %.2f,\n", latency.stdev))
  io.write(string.format("  \"latency_distribution\": {\n"))
  for _, p in pairs({ 50, 75, 90, 99 }) do
    io.write(string.format("    \"p%d\": %.2f", p, latency:percentile(p)))
    if p ~= 99 then io.write(",") end
    io.write("\n")
  end
  io.write("  }\n")
  io.write("}\n")
end