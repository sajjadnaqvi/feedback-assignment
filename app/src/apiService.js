import {makeRequest} from './HttpService.js'

export function login (data={})
{
    return makeRequest('post','/login', data);
}

export function register (data={})
{
    return makeRequest('post','/register', data);
}

export function getAuthenticatedUser ()
{
    return makeRequest('get','/me');
}

export function createFeedback (data={})
{
    return makeRequest('post','/feedbacks', data);
}

export function listAllFeedback (url,params={})
{
    url = url ?? '/feedbacks';
    return makeRequest('get', url, params);
}

export function createComment (data={})
{
    return makeRequest('post','/comments', data);
}

export function listAllComments (params={})
{
    return makeRequest('get','/comments', params);
}

export function listAllCategoriess (params={})
{
    return makeRequest('get','/categories', params);
}

export function getCommentOnFeedback (id)
{
    return makeRequest('get',`feedbacks/${id}/comments`);
}