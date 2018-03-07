import sys

class config():
    dim = 300
    dim_char = 100
    
    #sys.argv[1] takes read the second argument of python execution
    #example execution: python3 filename.py second_arg
    #result of sys.argv[1] from above call: "second_arg" 
    data_category = str(sys.argv[1])

    if __name__ == 'config':
        file_prepend = ""
    else:
        file_prepend = "extraction/sequence_tagging/"
    glove_filename = file_prepend + "data/_static/glove.6B/glove.6B.{}d.txt".format(dim)
    trimmed_filename = file_prepend + "data/" + data_category + "/glove.6B.{}d.trimmed.npz".format(dim)
    words_filename = file_prepend + "data/" + data_category + "/words.txt"
    tags_filename = file_prepend + "data/" + data_category + "/tags.txt"
    chars_filename = file_prepend + "data/" + data_category + "/chars.txt"
    dev_filename = file_prepend + "data/" + data_category + "/24Vision/iob/test_a.iob"
    test_filename = file_prepend + "data/" + data_category + "/24Vision/iob/test_b.iob"
    train_filename = file_prepend + "data/" + data_category + "/24Vision/iob/train.iob"
    max_iter = None # default: None
    lowercase = True
    train_embeddings = False
    nepochs = 1000
    dropout = 0.5
    batch_size = 5
    lr = 0.001
    lr_decay = 0.9
    nepoch_no_imprv = 10

    hidden_size = 300
    char_hidden_size = 100
    crf = True  # if crf, training will be (significantly) slower
    chars = True # if char embedding, training will be (significantly) slower
    output_path = file_prepend + "results/crf/" + data_category + "/"
    model_output = output_path + "model.weights/"
    log_path = output_path + "log.txt"
